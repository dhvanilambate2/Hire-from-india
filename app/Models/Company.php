<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'employer_id',
        'company_name',
        'company_logo',
        'company_email',
        'company_phone',
        'company_address',
        'city',
        'country',
        'timezone',
        'home_currency',
        'zip_code',
        'website_url',
    ];

    // ── Timezones List ──
    public static function getTimezones(): array
    {
        return [
            'Asia/Kolkata'        => '(UTC +05:30) India - Kolkata',
            'Asia/Dubai'          => '(UTC +04:00) UAE - Dubai',
            'Asia/Singapore'      => '(UTC +08:00) Singapore',
            'Asia/Tokyo'          => '(UTC +09:00) Japan - Tokyo',
            'Asia/Shanghai'       => '(UTC +08:00) China - Shanghai',
            'Asia/Karachi'        => '(UTC +05:00) Pakistan - Karachi',
            'Asia/Dhaka'          => '(UTC +06:00) Bangladesh - Dhaka',
            'Asia/Colombo'        => '(UTC +05:30) Sri Lanka - Colombo',
            'Asia/Kathmandu'      => '(UTC +05:45) Nepal - Kathmandu',
            'Europe/London'       => '(UTC +00:00) UK - London',
            'Europe/Paris'        => '(UTC +01:00) France - Paris',
            'Europe/Berlin'       => '(UTC +01:00) Germany - Berlin',
            'Europe/Moscow'       => '(UTC +03:00) Russia - Moscow',
            'America/New_York'    => '(UTC -05:00) USA - New York',
            'America/Chicago'     => '(UTC -06:00) USA - Chicago',
            'America/Denver'      => '(UTC -07:00) USA - Denver',
            'America/Los_Angeles' => '(UTC -08:00) USA - Los Angeles',
            'America/Toronto'     => '(UTC -05:00) Canada - Toronto',
            'America/Sao_Paulo'   => '(UTC -03:00) Brazil - São Paulo',
            'Australia/Sydney'    => '(UTC +11:00) Australia - Sydney',
            'Australia/Melbourne' => '(UTC +11:00) Australia - Melbourne',
            'Pacific/Auckland'    => '(UTC +13:00) New Zealand - Auckland',
            'Africa/Lagos'        => '(UTC +01:00) Nigeria - Lagos',
            'Africa/Cairo'        => '(UTC +02:00) Egypt - Cairo',
            'Africa/Johannesburg' => '(UTC +02:00) South Africa - Johannesburg',
        ];
    }

    // ── Currencies List ──
    public static function getCurrencies(): array
    {
        return [
            'INR' => '₹ INR - Indian Rupee',
            'USD' => '$ USD - US Dollar',
            'EUR' => '€ EUR - Euro',
            'GBP' => '£ GBP - British Pound',
            'AED' => 'د.إ AED - UAE Dirham',
            'SGD' => 'S$ SGD - Singapore Dollar',
            'AUD' => 'A$ AUD - Australian Dollar',
            'CAD' => 'C$ CAD - Canadian Dollar',
            'JPY' => '¥ JPY - Japanese Yen',
            'CNY' => '¥ CNY - Chinese Yuan',
            'PKR' => '₨ PKR - Pakistani Rupee',
            'BDT' => '৳ BDT - Bangladeshi Taka',
            'LKR' => 'Rs LKR - Sri Lankan Rupee',
            'NPR' => 'रू NPR - Nepalese Rupee',
            'SAR' => '﷼ SAR - Saudi Riyal',
            'QAR' => 'ر.ق QAR - Qatari Riyal',
            'BRL' => 'R$ BRL - Brazilian Real',
            'ZAR' => 'R ZAR - South African Rand',
            'NGN' => '₦ NGN - Nigerian Naira',
            'NZD' => 'NZ$ NZD - New Zealand Dollar',
            'CHF' => 'CHF - Swiss Franc',
            'SEK' => 'kr SEK - Swedish Krona',
            'RUB' => '₽ RUB - Russian Ruble',
        ];
    }

    // ── Countries List ──
    public static function getCountries(): array
    {
        return [
            'IN' => 'India',
            'US' => 'United States',
            'GB' => 'United Kingdom',
            'AE' => 'United Arab Emirates',
            'SG' => 'Singapore',
            'AU' => 'Australia',
            'CA' => 'Canada',
            'DE' => 'Germany',
            'FR' => 'France',
            'JP' => 'Japan',
            'CN' => 'China',
            'PK' => 'Pakistan',
            'BD' => 'Bangladesh',
            'LK' => 'Sri Lanka',
            'NP' => 'Nepal',
            'SA' => 'Saudi Arabia',
            'QA' => 'Qatar',
            'KW' => 'Kuwait',
            'OM' => 'Oman',
            'BH' => 'Bahrain',
            'MY' => 'Malaysia',
            'TH' => 'Thailand',
            'ID' => 'Indonesia',
            'PH' => 'Philippines',
            'VN' => 'Vietnam',
            'KR' => 'South Korea',
            'BR' => 'Brazil',
            'MX' => 'Mexico',
            'ZA' => 'South Africa',
            'NG' => 'Nigeria',
            'EG' => 'Egypt',
            'KE' => 'Kenya',
            'NZ' => 'New Zealand',
            'IE' => 'Ireland',
            'NL' => 'Netherlands',
            'SE' => 'Sweden',
            'CH' => 'Switzerland',
            'IT' => 'Italy',
            'ES' => 'Spain',
            'RU' => 'Russia',
        ];
    }

    // ── Relationships ──
    public function employer()
    {
        return $this->belongsTo(User::class, 'employer_id');
    }

    public function jobPosts()
    {
        return $this->hasManyThrough(JobPost::class, User::class, 'id', 'employer_id', 'employer_id', 'id');
    }

    // ── Accessors ──
    public function getLogoUrlAttribute()
    {
        if ($this->company_logo) {
            return asset('storage/' . $this->company_logo);
        }
        return null;
    }

    public function getHasLogoAttribute()
    {
        return !empty($this->company_logo);
    }

    public function getTimezoneLabelAttribute()
    {
        return self::getTimezones()[$this->timezone] ?? $this->timezone;
    }

    public function getCurrencyLabelAttribute()
    {
        return self::getCurrencies()[$this->home_currency] ?? $this->home_currency;
    }

    public function getCountryNameAttribute()
    {
        return self::getCountries()[$this->country] ?? $this->country;
    }

    public function getCurrencySymbolAttribute()
    {
        $symbols = [
            'INR' => '₹', 'USD' => '$', 'EUR' => '€', 'GBP' => '£',
            'AED' => 'د.إ', 'SGD' => 'S$', 'AUD' => 'A$', 'CAD' => 'C$',
            'JPY' => '¥', 'CNY' => '¥', 'PKR' => '₨', 'BDT' => '৳',
            'SAR' => '﷼', 'BRL' => 'R$', 'ZAR' => 'R', 'NGN' => '₦',
            'RUB' => '₽', 'CHF' => 'CHF',
        ];
        return $symbols[$this->home_currency] ?? $this->home_currency;
    }

    public function getFullLocationAttribute()
    {
        $parts = array_filter([
            $this->city,
            $this->country_name,
            $this->zip_code ? 'ZIP: ' . $this->zip_code : null,
        ]);
        return !empty($parts) ? implode(', ', $parts) : null;
    }
}
