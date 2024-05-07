<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Episode;

class UniqueEpisodeNumber implements Rule
{
    private $episodeId;

    public function __construct($episodeId)
    {
        $this->episodeId = $episodeId;
    }

    public function passes($attribute, $value)
    {
        return Episode::where('number', $value)
            ->where('id', '!=', $this->episodeId)
            ->count() == 0;
    }

    public function message()
    {
        return 'This episode already exists';
    }
}