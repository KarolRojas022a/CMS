<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ReceivedEmail;
use Webklex\IMAP\Facades\Client;

class ReceiveEmails extends Command
{
	protected $signature = 'mail:receive';
	protected $description = 'Consulta el buzón IMAP y guarda mensajes nuevos sin duplicarlos';

	public function handle(): int
	{
		$client = Client::account('default');
		$client->connect();

		$folder = $client->getFolder('INBOX');
		$messages = $folder->messages()
			->unseen()
			->limit(10)
			->get();

		$saved = 0;
		$duplicates = 0;

		foreach ($messages as $message) {
			$messageId = trim((string) $message->getMessageId()->first());

			if ($messageId === '') {
				$messageId = 'imap:default:INBOX:' . $message->getUid();
			}

			$sender = $message->getFrom()->first();
			$textBody = $message->getTextBody();
			$body = $textBody !== '' ? $textBody : $message->getHTMLBody();

			$email = ReceivedEmail::firstOrCreate(
				['message_id' => $messageId],
				[
					'from_email' => $sender->mail ?? '',
					'from_name' => $sender->personal ?? null,
					'subject' => $message->getSubject()->first(),
					'body' => $body,
					'received_at' => $message->getDate()->first(),
				]
			);

			if ($email->wasRecentlyCreated) {
				$saved++;
				$this->line('Guardado: ' . ($email->subject ?: '(sin asunto)'));
			} else {
				$duplicates++;
				$this->line('Duplicado omitido: ' . $messageId);
			}

			$message->setFlag(['Seen']);
		}

		$this->info("Correos nuevos: {$saved}; duplicados omitidos: {$duplicates}.");

		return self::SUCCESS;
	}
}