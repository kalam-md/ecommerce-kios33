<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Produk extends Model
{
    use Sluggable;

    protected $guarded = ['id'];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'nama_produk'
            ]
        ];
    }

    protected $casts = [
        'is_aktif' => 'boolean',
        'harga' => 'decimal:2',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function keranjang()
    {
        return $this->hasMany(Keranjang::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
