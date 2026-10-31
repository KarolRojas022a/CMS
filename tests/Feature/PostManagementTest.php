<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_pages_only_show_published_posts(): void
    {
        $user = User::factory()->create();
        $published = $user->posts()->create([
            'title' => 'Aviso público',
            'body' => 'Información para la comunidad.',
            'is_published' => true,
        ]);
        $user->posts()->create([
            'title' => 'Borrador interno',
            'body' => 'Este contenido todavía no es público.',
        ]);

        $this->get(route('pages.home'))
            ->assertOk()
            ->assertSee($published->title)
            ->assertDontSee('Borrador interno');

        $this->get(route('pages.posts'))
            ->assertOk()
            ->assertSee($published->title)
            ->assertDontSee('Borrador interno');
    }

    public function test_draft_post_cannot_be_viewed_on_public_route(): void
    {
        $post = User::factory()->create()->posts()->create([
            'title' => 'Borrador privado',
            'body' => 'No publicado.',
        ]);

        $this->get(route('posts.show', $post))->assertNotFound();
    }

    public function test_post_management_requires_authentication(): void
    {
        $this->get(route('posts.index'))->assertRedirect(route('login'));
        $this->get(route('posts.create'))->assertRedirect(route('login'));
    }

    public function test_dashboard_only_lists_the_authenticated_users_posts(): void
    {
        $user = User::factory()->create();
        $ownPost = $user->posts()->create([
            'title' => 'Publicación propia',
            'body' => 'Contenido propio.',
        ]);
        User::factory()->create()->posts()->create([
            'title' => 'Publicación ajena',
            'body' => 'Contenido ajeno.',
        ]);

        $this->actingAs($user)
            ->get(route('dashboard'))
            ->assertOk()
            ->assertSee($ownPost->title)
            ->assertDontSee('Publicación ajena');
    }

    public function test_authenticated_user_can_create_a_draft_and_publish_it(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('posts.store'), [
            'title' => 'Nueva publicación',
            'body' => 'Contenido institucional.',
        ]);

        $post = Post::query()->sole();
        $response->assertRedirect(route('posts.edit', $post));
        $this->assertFalse($post->is_published);
        $this->get(route('posts.show', $post))->assertNotFound();

        $this->patch(route('posts.update', $post), [
            'title' => $post->title,
            'body' => $post->body,
            'is_published' => '1',
        ])->assertRedirect(route('posts.edit', $post));

        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'is_published' => true,
        ]);

        $this->get(route('posts.show', $post))
            ->assertOk()
            ->assertSee('Contenido institucional.');
    }

    public function test_user_can_delete_their_own_post(): void
    {
        $post = User::factory()->create()->posts()->create([
            'title' => 'Publicación para eliminar',
            'body' => 'Contenido.',
            'is_published' => true,
        ]);

        $this->actingAs($post->user)
            ->delete(route('posts.destroy', $post))
            ->assertRedirect(route('posts.index'));

        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
        $this->get(route('posts.show', $post))->assertNotFound();
    }

    public function test_user_cannot_edit_or_delete_another_users_post(): void
    {
        $owner = User::factory()->create();
        $post = $owner->posts()->create([
            'title' => 'Publicación de otra persona',
            'body' => 'Contenido.',
        ]);

        $this->actingAs(User::factory()->create())
            ->patch(route('posts.update', $post), [
                'title' => 'Cambio no autorizado',
                'body' => 'Contenido.',
            ])
            ->assertForbidden();

        $this->actingAs(User::factory()->create())
            ->delete(route('posts.destroy', $post))
            ->assertForbidden();

        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'title' => 'Publicación de otra persona',
        ]);
    }
}
