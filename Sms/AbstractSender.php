<?php

namespace OCSoftwarePL\SmsApiBundle\Sms;

//that class may not have sense...
abstract class AbstractSender
{
    //that's not the best place fot these....

    // success for out point of view...
    const STATUS_SUCCESS_DRAFT = 'DRAFT';
    const STATUS_SUCCESS_DELIVERED = 'DELIVERED';
    const STATUS_SUCCESS_SENT = 'SENT';
    const STATUS_SUCCESS_QUEUE = 'QUEUE';

    const STATUS_FAIL_UNDELIVERED = 'UNDELIVERED';
    const STATUS_FAIL_EXPIRED = 'EXPIRED';
    const STATUS_FAIL_FAILED = 'FAILED';

    //and some more... UNKNOWN PENDING ACCEPTED RENEWAL STOP

    public function isSendTrySuccess($status)
    {
        return in_array($status, [
            self::STATUS_SUCCESS_DRAFT,
            self::STATUS_SUCCESS_QUEUE,
            self::STATUS_SUCCESS_SENT,
            self::STATUS_SUCCESS_DELIVERED
        ]);
    }

    public function isSendTryFailed($status)
    {
        return !$this->isSendTryFailed($status);
    }

    const CALLBACK_STATUS_NOT_FOUND = 401; // 'Nieznaleziona - Błędny numer ID lub raport wygasł',
    const CALLBACK_STATUS_EXPIRED = 402; // 'Przedawniona - Wiadomość niedostarczona z powodu zbyt długiegoczasu niedostępność numeru ',
    const CALLBACK_STATUS_SENT = 403; // 'Wysłana - Wiadomość została wysłana ale operator nie zwrócił jeszcze raportu doręczenia',
    const CALLBACK_STATUS_DELIVERED = 404; // 'Dostarczona - Wiadomość dotarła do odbiorcy',
    const CALLBACK_STATUS_UNDELIVERED = 405; // 'Niedostarczona - Wiadomość niedostarczona (np.: błędny numer, numer niedostępny)',
    const CALLBACK_STATUS_FAILED = 406; // 'Nieudana - Błąd podczas wysyłki wiadomości - prosimy zgłosić',
    const CALLBACK_STATUS_REJECTED = 407; // 'Nieudana - Błąd podczas wysyłki wiadomości - prosimy zgłosić',
    const CALLBACK_STATUS_UNKNOWN = 408; // 'Nieznany - Brak raportu doręczenia dla wiadomości (wiadomość doręczona lub brak możliwości doręczenia)',
    const CALLBACK_STATUS_QUEUE = 409; // 'Kolejka - Wiadomość czeka w kolejce na wysyłkę',
    const CALLBACK_STATUS_ACCEPTED = 410; // 'Zaakceptowana - Wiadomość przyjęta przez operatora',
    const CALLBACK_STATUS_RENEWAL = 411; // 'Ponawianie - Wykonana była próba połączenia która nie została odebrana, połączenie zostanie ponowione.'
    const CALLBACK_STATUS_STOP = 412;

    public function isCallbackStatusSuccess($status)
    {
        return in_array($status, [
            self::CALLBACK_STATUS_SENT,
            self::CALLBACK_STATUS_DELIVERED,
            self::CALLBACK_STATUS_QUEUE,
            self::CALLBACK_STATUS_ACCEPTED
        ]);
    }

    public function isCallbackStatusFail($status)
    {
        return !$this->isCallbackStatusSuccess($status);
    }

    private $errorCodesToMsg = [

        '8' => 'Błąd w odwołaniu (Prosimy zgłosić)',
        '11' => 'Zbyt długa lub brak wiadomości lub ustawiono parametr nounicode i pojawiły się znaki specjalne w wiadomości. Dla wysyłki VMS błąd oznacz brak pliku WAV lub błąd tekstu TTS (brak tekstu lub inne niż UTF-8 kodowanie).',
        '12' => 'Wiadomość składa się z większej ilości części niż określono w parametrze&max_parts',
        '13' => 'Brak prawidłowych numerów telefonów (numer błędny, stacjonarny (w przypadku wysyłki SMS) lub znajdujący się na czarnej liście)',
        '14' => 'Nieprawidłowe pole nadawcy',
        '17' => 'Nie można wysłać FLASH ze znakami specjalnymi',
        '18' => 'Nieprawidłowa liczba parametrów',
        '19' => 'Za dużo wiadomości w jednym odwołaniu',
        '20' => 'Nieprawidłowa liczba parametrów IDX',
        '21' => 'Wiadomość MMS ma za duży rozmiar (maksymalnie 300kB)',
        '22' => 'Błędny format SMIL',
        '23' => 'Błąd pobierania pliku dla wiadomości MMS lub VMS',
        '24' => 'Błędny format pobieranego pliku',
        '25' => 'Parametry &normalize oraz &datacoding nie mogą być używane jednocześnie.',
        '26' => 'Za długi temat wiadomości. Temat może zawierać maksymalnie 30 znaków.',
        '27' => 'Parametr IDX za długi. Maksymalnie 255 znaków',
        '28' => 'Błędna wartość parametru time_restriction. Dostępne wartości to FOLLOW, IGNORE lub NEAREST_AVAILABLE.',
        '30' => 'Brak parametru UDH jak podany jest datacoding=bin',
        '31' => 'Błąd konwersji TTS',
        '32' => 'Nie można wysyłać wiadomości Eco, MMS i VMS na zagraniczne numery lub wysyłka na zagranicę wyłączona na koncie.',
        '33' => 'Brak poprawnych numerów',
        '35' => 'Błędna wartość parametru tts_lector. Dostępne wartości: agnieszka, ewa, jacek, jan, maja',
        '36' => 'Nie można wysyłać wiadomości binarnych z ustawioną stopką.',
        '40' => 'Brak grupy o podanej nazwie',
        '41' => 'Wybrana grupa jest pusta (brak kontaktów w grupie)',
        '50' => 'Nie można zaplanować wysyłki na więcej niż 3 miesiące w przyszłość',
        '51' => 'Ustawiono błędną godzinę wysyłki, wiadomość VMS mogą być wysyłane tylko pomiędzy godzinami 8 a 22 ustawiono kombinację parametrów try i interval powodującą możliwość próby połączenia po godzinie 22.',
        '52' => 'Za dużo prób wysyłki wiadomości do jednego numeru (maksymalnie 10 prób w przeciągu 60sek do jednego numeru)',
        '53' => 'Nieunikalny parametr idx. Wiadomość o podanym idx została wysłana w ostatnich czterech dniach lub ' .
            'jest zaplanowana do wysyłki w przyszłości przy wykorzystaniu parametru &check_idx=1.',
        '54' => 'Błędny format daty. Ustawiono sprawdzanie poprawności daty &date_validate=1',
        '55' => 'Brak numerów stacjonarnych w wysyłce i ustawiony parametr skip_gsm',
        '56' => 'Różnica pomiędzy datą wysyłki, a datą wygaśnięcia nie może być mniejsza niż 15 minut' .
            'i większa niż 12 godzin',
        '57' => 'Numer znajduje się na czarnej liście dla danego użytkownika.',
        '60' => 'Grupa kodów o podanej nazwie nie istnieje.',
        '61' => 'Data ważności grupy kodów minęła.',
        '62' => 'Brak wolnych kodów w podanej grupie (wszystkie kody zostały już wykorzystane).',
        '65' => 'Brak wystarczającej liczby kodów rabatowych dla wysyłki. Liczba niewykorzystanych kodów w grupie' .
            'musi być co najmniej równa liczbie numerów w wysyłce.',
        '66' => 'W treści wiadomości brak jest znacznika [%kod%]' .
            'dla wysyłki z parametrem &discount_group' .
            '(znacznik taki jest wymagany).',
        '70' => 'Błędny adres CALLBACK w parametrze' . 'notify_url',
        '72' => '-',
        '74' => 'Data wysyłki nie spełnia ograniczeń czasowych ustawionych na koncie',
        '101' => 'Niepoprawne lub brak danych autoryzacji.' .
            'UWAGA!' . 'Hasło do API może być inne niż hasło do Panelu' . 'Klienta',
        '102' => 'Nieprawidłowy login lub hasło',
        '103' => 'Brak punków dla tego użytkownika',
        '104' => 'Brak szablonu',
        '105' => 'Błędny adres IP (włączony filtr IP dla interfejsu API)',
        '110' => 'Usługa (SMS, MMS, VMS lub HLR) nie jest dostępna na danym koncie.',
        '200' => 'Nieudana próba wysłania wiadomości, prosimy ponowić odwołanie',
        '201' => 'Wewnętrzny błąd systemu (prosimy zgłosić)',
        '202' => 'Zbyt duża ilość jednoczesnych odwołań do serwisu, wiadomość nie została wysłana (prosimy odwołać' .
            'się ponownie)',
        '203' => 'Zbyt wiele odwołań do serwisu. Spróbuj ponownie później.',
        '300' => 'Nieprawidłowa wartość pola' . 'points' . '(przy użyciu pola' . 'points' . 'jest wymagana wartość 1)',
        '301' => 'Wiadomość o podanym ID nie istnieje lub jest zaplanowana do wysłania w przeciągu najbliższych 60',
        'sekund (nie można usunąć takiej wiadomości).',
        '400' => 'Nieprawidłowy ID statusu wiadomości.',
        '999' => 'Wewnętrzny błąd systemu (prosimy zgłosić).',
    ];

    public function getErrorCodeMsg($code)
    {
        if (isset($this->errorCodesToMsg[$code])) {
            return $this->errorCodesToMsg[$code];
        }
        return 'uknown error';
    }

}