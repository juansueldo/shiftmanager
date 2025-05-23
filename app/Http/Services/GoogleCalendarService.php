namespace App\Services;

use Google_Client;
use Google_Service_Calendar;
use Google_Service_Calendar_Event;
use Google_Service_Calendar_EventDateTime;

class GoogleCalendarService
{
    protected $client;
    protected $service;

    public function __construct()
    {
        $this->client = new Google_Client();
        $this->client->setAuthConfig(storage_path('app/google-calendar/credentials.json'));
        $this->client->addScope(Google_Service_Calendar::CALENDAR);
        $this->client->setAccessType('offline');
        $this->client->setPrompt('select_account consent');

        // Aquí deberías recuperar el token de acceso del usuario autenticado
        // Por simplicidad, podrías cargarlo desde storage temporalmente
        $tokenPath = storage_path('app/google-calendar/token.json');
        if (file_exists($tokenPath)) {
            $this->client->setAccessToken(json_decode(file_get_contents($tokenPath), true));
        }

        $this->service = new Google_Service_Calendar($this->client);
    }

    public function createEvent($summary, $description, $startDateTime, $endDateTime)
    {
        $event = new Google_Service_Calendar_Event([
            'summary' => $summary,
            'description' => $description,
            'start' => [
                'dateTime' => $startDateTime,
                'timeZone' => 'America/Argentina/Buenos_Aires',
            ],
            'end' => [
                'dateTime' => $endDateTime,
                'timeZone' => 'America/Argentina/Buenos_Aires',
            ],
        ]);

        return $this->service->events->insert('primary', $event);
    }
}
