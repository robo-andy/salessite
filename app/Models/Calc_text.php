<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calc_Text extends Model
{
    use HasFactory;

    protected $table = 'calc_text';

    protected $fillable = [
        'heading_one', 'heading_tab', 'heading_tab_two', 'heading_tab_three', 
        'heading_two', 'heading_three', 'heading_four',
        'text_one', 'text_two', 'text_three', 'text_four', 'text_five', 'text_six', 
        'text_seven', 'text_eight', 'text_nine', 'text_ten', 'text_eleven', 
        'text_twelve', 'text_thirteen', 'text_fourteen', 'text_fifteen', 
        'text_sixteen', 'text_seventeen', 'text_eighteen', 'text_nineteen', 
        'text_twenty', 'text_twenty_one', 'text_twenty_two', 'text_twenty_three', 
        'text_twenty_four', 'text_twenty_five', 'text_twenty_six', 'text_twenty_seven'
    ];
}
