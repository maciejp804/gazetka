<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    use HasFactory;

    protected $fillable = [
        'ad_unit_id',
        'network',
        'ad_type',
        'target_url',
        'code',
        'size',
        'timeout',
        'status',
    ];

    public function leaflets()
    {
        return $this->belongsToMany(Leaflet::class, 'leaflet_ada')
            ->withPivot('after_page', 'priority')
            ->withTimestamps();
    }

    public function render()
    {
        switch ($this->network)
        {
            case 'google':
                return $this->renderGoogleAd();
                break;
            case 'tradedoubler':
            case 'tradetracker':
                return $this->code;
                break;
            default:
                return $this->code ?? '';
                break;
        }
    }

    public function renderGoogleAd()
    {
        return "<div id='{$this->ad_unit_id}' style='width: {$this->getWidth()}px; height: {$this->getHeight()}px;'>
                    <script>
                        googletag.cmd.push(function() { googletag.display('{$this->ad_unit_id}'); });
                    </script>
                </div>";
    }

    public function getWidth()
    {
        return explode('x', $this->size)[0] ?? 0;
    }

    public function getHeight()
    {
        return explode('x', $this->size)[1] ?? 0;
    }
}
