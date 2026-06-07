<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ListingAgreementTemplate extends Model
{
    protected $fillable = [
        'platform_name',
        'platform_email',
        'platform_website',
        'platform_phone',
        'platform_tagline',
        'platform_representative_name',
        'platform_signature_path',
        'intro_text',
        'damage_report_hours',
        'termination_notice_days',
        'commission_rate',
        'payment_method',
        'payment_timeline',
        'footer_services_text',
        'sections',
    ];

    protected $casts = [
        'sections' => 'array',
        'damage_report_hours' => 'integer',
        'termination_notice_days' => 'integer',
    ];

    public static function current(): self
    {
        $row = static::query()->first();
        if ($row) {
            return $row;
        }

        return static::query()->create([
            'platform_name' => 'Stay Nets',
            'platform_email' => 'staynets2@gmail.com',
            'platform_website' => 'www.staynets.com',
            'platform_phone' => '+250784251094/250788788633',
            'platform_tagline' => 'Stay Nets - One Platform, Endless Destinations.',
            'platform_representative_name' => 'Joseph K',
            'platform_signature_path' => null,
            'intro_text' => self::defaultIntro(),
            'damage_report_hours' => 24,
            'termination_notice_days' => 30,
            'commission_rate' => '5%',
            'payment_method' => 'Bank transfer / Mobile Money / Card',
            'payment_timeline' => 'Within 7–14 days after guest checkout',
            'footer_services_text' => 'Booking Engine: Hotel, Apartment, Villa House, Tour Package and Car Rental.',
            'sections' => self::defaultSections(),
        ]);
    }

    public static function defaultIntro(): string
    {
        return "This Agreement is made between:\n\n"
            . "1. Platform Owner: Stay Nets, operating an online booking platform (“Platform”)\n\n"
            . "AND\n\n"
            . "2. Property Owner / Host (“Host”)";
    }

    /**
     * @return array<int, array{heading: string, items: array<int, string>}>
     */
    public static function defaultSections(): array
    {
        return [
            [
                'heading' => '1. PURPOSE',
                'items' => [
                    'The Host agrees to list their property on the Platform, and the Platform agrees to market and facilitate bookings for the Host.',
                ],
            ],
            [
                'heading' => '2. PROPERTY DETAILS',
                'items' => [
                    'Property Name: [PROPERTY NAME]',
                    'Location: [LOCATION]',
                    'Property Type: [TYPE]',
                ],
            ],
            [
                'heading' => '3. PLATFORM SERVICES',
                'items' => [
                    'Display the property listing to users',
                    'Process reservations',
                    'Provide customer support tools',
                    'Promote the property online',
                ],
            ],
            [
                'heading' => '4. COMMISSION & PAYMENTS',
                'items' => [
                    'Commission Rate: [COMMISSION] per booking unless otherwise agreed',
                    'Payment Method: [PAYMENT METHOD]',
                    'Payment Timeline: [PAYMENT TIMELINE]',
                ],
            ],
            [
                'heading' => '5. HOST RESPONSIBILITIES',
                'items' => [
                    'Provide accurate property information',
                    'Maintain availability and pricing',
                    'Deliver the service booked by guests',
                    'Handle guest complaints related to the property',
                ],
            ],
            [
                'heading' => '6. BOOKINGS & CONTRACT',
                'items' => [
                    'A booking becomes valid once confirmed and paid',
                    'The agreement for stay is between Host and Guest',
                    'The Platform acts only as an intermediary',
                ],
            ],
            [
                'heading' => '7. CANCELLATION POLICY',
                'items' => [
                    'The Host must define:',
                    'Free cancellation period (if any)',
                    'Refund conditions',
                    'No-show policy',
                ],
            ],
            [
                'heading' => '8. DAMAGE & LIABILITY',
                'items' => [
                    'Guests are responsible for damages',
                    'Host must report damages within [X] hours',
                    'Platform is not liable for property damage or guest behavior',
                ],
            ],
            [
                'heading' => '9. CONTENT & LISTING RIGHTS',
                'items' => [
                    'Host grants Platform the right to use:',
                    'Photos',
                    'Property descriptions',
                    'Platform may promote listings for marketing',
                ],
            ],
            [
                'heading' => '10. TERM & TERMINATION',
                'items' => [
                    'Start Date: [START DATE]',
                    'Either party may terminate with [30 days] notice',
                    'Platform may suspend listing for policy violations',
                ],
            ],
            [
                'heading' => '11. LEGAL COMPLIANCE',
                'items' => [
                    'The Host must:',
                    'Follow local laws and tax regulations',
                    'Ensure property is legally rentable',
                ],
            ],
            [
                'heading' => '12. LIMITATION OF LIABILITY',
                'items' => [
                    'The Platform:',
                    'Is not responsible for guest behavior',
                    'Does not guarantee bookings',
                    'Is not liable for indirect losses',
                ],
            ],
            [
                'heading' => '13. GOVERNING LAW',
                'items' => [
                    'This Agreement shall be governed by the laws of Rwanda',
                ],
            ],
            [
                'heading' => '14. SIGNATURES',
                'items' => [
                    'By signing below, the Host confirms they have read and accept this Property Listing Agreement.',
                ],
            ],
        ];
    }
}
