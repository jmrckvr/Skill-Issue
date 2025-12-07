<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Company;
use App\Models\User;
use App\Models\CommunityThread;
use App\Models\CommunityMessage;

class CommunityThreadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get or create test user for messages
        $testUser = User::firstOrCreate(
            ['email' => 'jobseeker@example.com'],
            [
                'name' => 'John Jobseeker',
                'password' => bcrypt('password123'),
                'email_verified_at' => now(),
            ]
        );

        // Thread data structure: [company_name, thread_data]
        $threadsData = [
            'ACME Tech Solutions' => [
                [
                    'title' => 'Is the Junior Developer role still open?',
                    'messages' => [
                        [
                            'text' => 'Hi! I applied last week. Is the Junior Developer position still accepting applicants?',
                            'is_from_company' => false,
                        ],
                        [
                            'text' => 'Yes! We\'re still reviewing applications. Expect an update within 3–5 days.',
                            'is_from_company' => true,
                        ],
                        [
                            'text' => 'Thank you!',
                            'is_from_company' => false,
                        ],
                        [
                            'text' => 'You\'re welcome — feel free to ask anything else.',
                            'is_from_company' => true,
                        ],
                    ],
                ],
                [
                    'title' => 'Tech stack for current projects?',
                    'messages' => [
                        [
                            'text' => 'Can you tell me what tech stack your development team uses?',
                            'is_from_company' => false,
                        ],
                        [
                            'text' => 'We primarily use Laravel, Vue.js, and AWS. We also work with React and Node.js for some projects.',
                            'is_from_company' => true,
                        ],
                        [
                            'text' => 'Great! That\'s helpful. Thanks for the info.',
                            'is_from_company' => false,
                        ],
                    ],
                ],
            ],
            'Global Finance PH' => [
                [
                    'title' => 'Hiring Timeline for Accounting Assistant',
                    'messages' => [
                        [
                            'text' => 'Hello, may I know the hiring timeline?',
                            'is_from_company' => false,
                        ],
                        [
                            'text' => 'Shortlisted applicants receive emails within 1 week.',
                            'is_from_company' => true,
                        ],
                        [
                            'text' => 'Noted, thanks!',
                            'is_from_company' => false,
                        ],
                        [
                            'text' => 'Thank you for your interest in Global Finance.',
                            'is_from_company' => true,
                        ],
                    ],
                ],
                [
                    'title' => 'CPA requirement for Analyst role',
                    'messages' => [
                        [
                            'text' => 'Is CPA certification required for the Financial Analyst position?',
                            'is_from_company' => false,
                        ],
                        [
                            'text' => 'CPA is preferred but not required. We value experience and strong analytical skills.',
                            'is_from_company' => true,
                        ],
                        [
                            'text' => 'Perfect! I\'ll apply soon.',
                            'is_from_company' => false,
                        ],
                    ],
                ],
            ],
            'InnovateHub' => [
                [
                    'title' => 'Work-from-home setup for UI/UX roles?',
                    'messages' => [
                        [
                            'text' => 'Do you offer hybrid or WFH for UI/UX roles?',
                            'is_from_company' => false,
                        ],
                        [
                            'text' => 'Yes, we offer hybrid flexibility depending on the project. Most of our design team works from home 3 days a week.',
                            'is_from_company' => true,
                        ],
                        [
                            'text' => 'Great to know! Thank you.',
                            'is_from_company' => false,
                        ],
                    ],
                ],
                [
                    'title' => 'Portfolio requirements for design positions',
                    'messages' => [
                        [
                            'text' => 'What should I include in my design portfolio for your review?',
                            'is_from_company' => false,
                        ],
                        [
                            'text' => 'Include 3-5 of your best projects showing your design process, user research, and final results. Digital or PDF format is fine.',
                            'is_from_company' => true,
                        ],
                        [
                            'text' => 'Got it! I\'ll prepare my portfolio.',
                            'is_from_company' => false,
                        ],
                        [
                            'text' => 'Sounds great! Looking forward to seeing your work.',
                            'is_from_company' => true,
                        ],
                    ],
                ],
            ],
            'SoftCloud Systems' => [
                [
                    'title' => 'Interview process details',
                    'messages' => [
                        [
                            'text' => 'How many interview stages do you have?',
                            'is_from_company' => false,
                        ],
                        [
                            'text' => 'Usually 2–3 stages depending on the position. First is a technical screening, then one or two rounds with our team leads.',
                            'is_from_company' => true,
                        ],
                        [
                            'text' => 'Thanks!',
                            'is_from_company' => false,
                        ],
                    ],
                ],
                [
                    'title' => 'Salary negotiation after offer',
                    'messages' => [
                        [
                            'text' => 'Is the salary offer negotiable after the job offer is extended?',
                            'is_from_company' => false,
                        ],
                        [
                            'text' => 'Yes, we\'re open to discussions within reasonable ranges based on your experience and market rates.',
                            'is_from_company' => true,
                        ],
                        [
                            'text' => 'That\'s reassuring. Thank you for being transparent!',
                            'is_from_company' => false,
                        ],
                        [
                            'text' => 'You\'re welcome! We believe in fair compensation.',
                            'is_from_company' => true,
                        ],
                    ],
                ],
                [
                    'title' => 'Benefits package details',
                    'messages' => [
                        [
                            'text' => 'Can you share what\'s included in your benefits package?',
                            'is_from_company' => false,
                        ],
                        [
                            'text' => 'We offer health insurance, 15 days PTO, professional development budget, and gym membership.',
                            'is_from_company' => true,
                        ],
                    ],
                ],
            ],
            'Prime Logistics' => [
                [
                    'title' => 'Driver position requirements',
                    'messages' => [
                        [
                            'text' => 'What are the requirements for delivery driver applicants?',
                            'is_from_company' => false,
                        ],
                        [
                            'text' => 'Valid driver\'s license, clean driving record, and at least 1 year commercial driving experience.',
                            'is_from_company' => true,
                        ],
                        [
                            'text' => 'Got it, thank you.',
                            'is_from_company' => false,
                        ],
                    ],
                ],
                [
                    'title' => 'Vehicle inspection and insurance',
                    'messages' => [
                        [
                            'text' => 'Do drivers need their own vehicles or does the company provide?',
                            'is_from_company' => false,
                        ],
                        [
                            'text' => 'We provide vehicles for all drivers. Full insurance is covered by the company.',
                            'is_from_company' => true,
                        ],
                        [
                            'text' => 'That\'s excellent! Very interested in applying.',
                            'is_from_company' => false,
                        ],
                        [
                            'text' => 'Great! We\'d love to have you join our team. Apply here: [link]',
                            'is_from_company' => true,
                        ],
                    ],
                ],
            ],
        ];

        // Define logo paths for each company
        $logoMap = [
            'ACME Tech Solutions' => 'logos/acme-tech.svg',
            'Global Finance PH' => 'logos/global-finance.jpg',
            'InnovateHub' => 'logos/startuphub.jpg',
            'SoftCloud Systems' => 'logos/infotech.jpg',
            'Prime Logistics' => 'logos/logistics.jpg',
        ];

        $industryMap = [
            'ACME Tech Solutions' => 'Information Technology',
            'Global Finance PH' => 'Finance & Banking',
            'InnovateHub' => 'Technology & Design',
            'SoftCloud Systems' => 'Software Development',
            'Prime Logistics' => 'Logistics & Transportation',
        ];

        // Create threads and messages for each company
        foreach ($threadsData as $companyName => $threads) {
            $company = Company::where('name', $companyName)->first();

            if (!$company) {
                // If the specific company doesn't exist, create it as a placeholder
                $company = Company::create([
                    'user_id' => User::whereNotNull('id')->first()?->id ?? 1,
                    'name' => $companyName,
                    'description' => 'A reputable company offering diverse career opportunities.',
                    'website' => strtolower(str_replace(' ', '', $companyName)) . '.com',
                    'phone' => '+63-2-1234-5678',
                    'email' => 'careers@' . strtolower(str_replace(' ', '', $companyName)) . '.com',
                    'city' => 'Manila',
                    'state' => 'Metro Manila',
                    'country' => 'Philippines',
                    'employee_count' => 200,
                    'industry' => $industryMap[$companyName] ?? 'Technology',
                    'logo_path' => $logoMap[$companyName] ?? null,
                    'is_verified' => true,
                ]);
            } else {
                // Update logo path if it exists and is null
                if (!$company->logo_path && isset($logoMap[$companyName])) {
                    $company->update(['logo_path' => $logoMap[$companyName]]);
                }
            }

            // Create threads for this company
            foreach ($threads as $threadData) {
                $thread = CommunityThread::create([
                    'company_id' => $company->id,
                    'user_id' => $testUser->id,
                    'title' => $threadData['title'],
                    'last_activity_at' => now()->subHours(rand(1, 72)),
                ]);

                // Create messages for this thread
                foreach ($threadData['messages'] as $index => $messageData) {
                    CommunityMessage::create([
                        'community_thread_id' => $thread->id,
                        'user_id' => $messageData['is_from_company']
                            ? ($company->user_id ?? $testUser->id)
                            : $testUser->id,
                        'message' => $messageData['text'],
                        'is_from_company' => $messageData['is_from_company'],
                        'created_at' => $thread->created_at->addHours($index + 1),
                    ]);
                }

                // Update last activity timestamp to match the last message
                $lastMessage = $thread->messages()->latest()->first();
                if ($lastMessage) {
                    $thread->update([
                        'last_activity_at' => $lastMessage->created_at,
                    ]);
                }
            }
        }

        $this->command->info('Community threads seeded successfully!');
    }
}
