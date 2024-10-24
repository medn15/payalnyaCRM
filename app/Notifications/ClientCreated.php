namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ClientCreated extends Notification implements ShouldQueue // Добавьте интерфейс ShouldQueue
{
    use Queueable;

    protected $client;

    public function __construct($client)
    {
        $this->client = $client;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        \Log::info('Sending email to: ' . $notifiable->email); // Логируем адрес
        return (new MailMessage)
        ->greeting('Hello ' . $this->client->name . '!')
        ->line('Your account has been created successfully.')
        ->action('View Account', url('/clients/' . $this->client->id))
        ->line('Thank you for using our application!');
    }

    public function retryAfter()
    {
        return 10; // Повторная попытка через 10 секунд
    }
    public function tries()
    {
        return 3; // Максимальное количество попыток
    }

}
