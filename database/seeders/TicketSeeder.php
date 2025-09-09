<?php

namespace Database\Seeders;

use App\Models\Ticket;
use Illuminate\Database\Seeder;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Ticket::query()
            ->upsert(
                $this->getRealExamples(),
                ['id']
            );

        Ticket::factory(2)
            ->notes()
            ->category()
            ->create();

        Ticket::factory(5)
            ->notes()
            ->category()
            ->inProgress()
            ->create();

        Ticket::factory(3)
            ->notes()
            ->category()
            ->closed()
            ->create();
    }

    protected function getRealExamples(): array
    {
        return [
            [
                'subject' => 'Invoice shows wrong amount',
                'body' => 'I was charged $120 for my subscription this month, but my plan is supposed to cost only $80. Can you please check why the invoice amount is incorrect?',
            ],
            [
                'subject' => 'Website login not working',
                'body' => 'Every time I try to log in to my account, the page just refreshes without any error message. I already tried resetting my password but it didn’t help.',
            ],
            [
                'subject' => 'Need to update email address',
                'body' => 'I recently changed my primary email and I want to update it in my profile. However, the system keeps telling me the new email is already in use, which is not true.',
            ],
            [
                'subject' => 'Does the new model support Bluetooth 5.3?',
                'body' => 'I am considering purchasing the latest version of your headphones. Before ordering, I’d like to confirm if they support Bluetooth 5.3 and multipoint connectivity.',
            ],
            [
                'subject' => 'Package delayed for two weeks',
                'body' => "I placed an order on July 5th and the tracking page still says 'in transit'. It has already been two weeks and I urgently need the items. Can you check the delivery status?",
            ],

            [
                'subject' => 'Requesting refund for damaged item',
                'body' => 'My order arrived yesterday but the screen of the tablet was cracked right out of the box. I want to return it and request a full refund as soon as possible.',
            ],
            [
                'subject' => 'Loving the new dashboard design',
                'body' => 'Just wanted to say the new dashboard UI looks amazing! It’s much easier to navigate and faster to load. Great job to the design team!',
            ],
            [
                'subject' => 'What are your customer support hours?',
                'body' => 'I’m based in Europe and I’d like to know during which hours I can contact your customer service team for live chat assistance.',
            ],
        ];
    }
}
