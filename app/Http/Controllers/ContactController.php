<?php
namespace App\Http\Controllers;
use App\Mail\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
class ContactController extends Controller
{
 public function create()
 {
 return view('contact.create');
 }
 public function send(Request $request)
 {
 return $this->store($request);
 }
 public function store(Request $request)
 {
 $data = $request->validate([
 'name' => ['required','string','max:100'],
 'email' => ['required','email','max:255'],
 'message' => ['required','string','max:5000'],
 ]);
 try {
 Mail::to(config('mail.from.address'))
 ->send(new ContactMessage(
 $data['name'],
 $data['email'],
 $data['message']
 ));
 } catch (\Throwable $exception) {
 report($exception);

 return back()->withInput()->with(
 'error',
 'No se pudo enviar el mensaje. Revisa la configuración del correo e inténtalo de nuevo.'
 );
 }

 $successMessage = config('mail.default') === 'log'
 ? 'Mensaje registrado para pruebas; no se envió por correo.'
 : 'Mensaje enviado correctamente.';

 return back()->with('success', $successMessage);
 }
}

