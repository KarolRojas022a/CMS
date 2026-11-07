<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_editor_cannot_access_user_management(): void
    {
        $editor = User::factory()->create(['role' => 'editor']);
        $this->assertTrue($editor->is_active);

        $this->actingAs($editor)
            ->get(route('users.index'))
            ->assertForbidden();
    }

    public function test_admin_can_create_update_search_and_reset_user_password(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)
            ->post(route('users.store'), [
                'name' => 'Nuevo Editor',
                'email' => 'editor@example.com',
                'role' => 'editor',
                'password' => 'StrongPass123',
                'password_confirmation' => 'StrongPass123',
            ])
            ->assertRedirect(route('users.index'));

        $editor = User::query()->where('email', 'editor@example.com')->sole();
        $this->assertSame('editor', $editor->role);
        $this->assertTrue($editor->is_active);
        $this->assertTrue(Hash::check('StrongPass123', $editor->password));

        $this->actingAs($admin)
            ->get(route('users.index', ['search' => 'Nuevo Editor']))
            ->assertOk()
            ->assertSee('editor@example.com');

        $this->put(route('users.update', $editor), [
            'name' => 'Editor Actualizado',
            'email' => 'updated@example.com',
            'role' => 'editor',
        ])->assertRedirect(route('users.index'));

        $this->put(route('users.password', $editor), [
            'password' => 'UpdatedPass123',
            'password_confirmation' => 'UpdatedPass123',
        ])->assertRedirect(route('users.edit', $editor));

        $this->assertDatabaseHas('users', [
            'id' => $editor->id,
            'name' => 'Editor Actualizado',
            'email' => 'updated@example.com',
        ]);
        $this->assertTrue(Hash::check('UpdatedPass123', $editor->fresh()->password));
    }

    public function test_user_management_validates_duplicate_emails_roles_and_passwords(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $existing = User::factory()->create();

        $this->actingAs($admin)
            ->from(route('users.create'))
            ->post(route('users.store'), [
                'name' => 'Invalid User',
                'email' => $existing->email,
                'role' => 'superuser',
                'password' => 'short',
                'password_confirmation' => 'does-not-match',
            ])
            ->assertRedirect(route('users.create'))
            ->assertSessionHasErrors(['email', 'role', 'password']);

        $this->assertDatabaseMissing('users', ['name' => 'Invalid User']);
    }

    public function test_admin_can_deactivate_and_reactivate_an_editor_but_not_themself(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $editor = User::factory()->create(['role' => 'editor']);

        $this->actingAs($admin)
            ->patch(route('users.status', $editor), ['is_active' => '0'])
            ->assertRedirect(route('users.index'));

        $this->assertDatabaseHas('users', ['id' => $editor->id, 'is_active' => false]);

        $this->patch(route('users.status', $editor), ['is_active' => '1'])
            ->assertRedirect(route('users.index'));

        $this->assertDatabaseHas('users', ['id' => $editor->id, 'is_active' => true]);

        $this->patch(route('users.status', $admin), ['is_active' => '0'])
            ->assertSessionHasErrors('is_active');

        $this->assertDatabaseHas('users', ['id' => $admin->id, 'is_active' => true]);
    }

    public function test_last_active_admin_cannot_be_demoted_or_deactivated(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)
            ->from(route('users.edit', $admin))
            ->put(route('users.update', $admin), [
                'name' => $admin->name,
                'email' => $admin->email,
                'role' => 'editor',
            ])
            ->assertRedirect(route('users.edit', $admin))
            ->assertSessionHasErrors('role');

        $this->patch(route('users.status', $admin), ['is_active' => '0'])
            ->assertSessionHasErrors('is_active');

        $this->assertDatabaseHas('users', [
            'id' => $admin->id,
            'role' => 'admin',
            'is_active' => true,
        ]);
    }

    public function test_inactive_accounts_cannot_log_in(): void
    {
        $user = User::factory()->create([
            'is_active' => false,
            'password' => Hash::make('Password123!'),
        ]);

        $this->from(route('login'))
            ->post(route('login.store'), [
                'email' => $user->email,
                'password' => 'Password123!',
            ])
            ->assertRedirect(route('login'))
            ->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_admin_dashboard_includes_all_posts_and_editors_only_see_their_own(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $editor = User::factory()->create(['role' => 'editor']);
        $adminPost = $admin->posts()->create(['title' => 'Post administrado', 'body' => 'Contenido.']);
        $editorPost = $editor->posts()->create(['title' => 'Post del editor', 'body' => 'Contenido.']);

        $this->actingAs($admin)
            ->get(route('dashboard'))
            ->assertOk()
            ->assertSee($adminPost->title)
            ->assertSee($editorPost->title)
            ->assertSee('Administrar usuarios');

        $this->actingAs($editor)
            ->get(route('dashboard'))
            ->assertOk()
            ->assertSee($editorPost->title)
            ->assertDontSee($adminPost->title)
            ->assertDontSee('Administrar usuarios');
    }

    public function test_admin_can_edit_and_delete_posts_from_any_user(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $editor = User::factory()->create(['role' => 'editor']);
        $post = $editor->posts()->create(['title' => 'Post del editor', 'body' => 'Contenido.']);

        $this->actingAs($admin)
            ->get(route('posts.index'))
            ->assertOk()
            ->assertSee($post->title);

        $this->patch(route('posts.update', $post), [
            'title' => 'Post actualizado por admin',
            'body' => 'Contenido actualizado.',
        ])->assertRedirect(route('posts.edit', $post));

        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'title' => 'Post actualizado por admin',
        ]);

        $this->delete(route('posts.destroy', $post))
            ->assertRedirect(route('posts.index'));

        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
    }
}
