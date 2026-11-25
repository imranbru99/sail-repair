<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\KnowledgeArticle;
use App\Models\Payment;
use App\Models\Post;
use App\Models\Product;
use App\Models\Project;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        foreach (['admin', 'manager', 'staff'] as $role) {
            Role::findOrCreate($role);
        }

        $admin = User::query()->updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'phone' => '(401) 555-0155',
            ]
        );
        $admin->syncRoles(['admin']);

        User::query()->updateOrCreate(
            ['email' => 'manager@windstitchloft.example'],
            [
                'name' => 'Sofia Reyes',
                'password' => Hash::make('password'),
                'role' => 'manager',
                'phone' => '(401) 555-0155',
            ]
        )->syncRoles(['manager']);

        User::query()->updateOrCreate(
            ['email' => 'loft@windstitchloft.example'],
            [
                'name' => 'Marcus Hale',
                'password' => Hash::make('password'),
                'role' => 'staff',
                'phone' => '(401) 555-0155',
            ]
        )->syncRoles(['staff']);

        $settings = [
            'company_name' => 'Windstitch Sail Loft',
            'company_phone' => '(401) 555-0155',
            'company_email' => 'hello@windstitchloft.example',
            'whatsapp' => '14015550155',
            'service_area' => 'Newport, Middletown, Bristol & Narragansett Bay',
            'tax_rate' => '7.00',
        ];
        foreach ($settings as $key => $value) {
            Setting::setValue($key, $value);
        }

        $products = [
            ['name' => 'Dacron Cloth Yard', 'sku' => 'WS-DC-1', 'category' => 'supplies', 'unit_cost' => 14, 'unit_price' => 42, 'stock_qty' => 80],
            ['name' => 'Sunbrella Yard', 'sku' => 'WS-SB-1', 'category' => 'supplies', 'unit_cost' => 18, 'unit_price' => 55, 'stock_qty' => 60],
            ['name' => 'Marine Thread Spool', 'sku' => 'WS-TH-1', 'category' => 'supplies', 'unit_cost' => 6, 'unit_price' => 18, 'stock_qty' => 100],
            ['name' => 'Batten Set (main)', 'sku' => 'WS-BT-1', 'category' => 'parts', 'unit_cost' => 35, 'unit_price' => 110, 'stock_qty' => 20],
            ['name' => 'Loft Labor Hour', 'sku' => 'WS-LAB-H', 'category' => 'labor', 'unit_cost' => 0, 'unit_price' => 95, 'stock_qty' => 999],
            ['name' => 'Sail Repair Minimum', 'sku' => 'WS-RP-1', 'category' => 'service', 'unit_cost' => 25, 'unit_price' => 125, 'stock_qty' => 999],
            ['name' => 'UV Cover Package', 'sku' => 'WS-UV-1', 'category' => 'service', 'unit_cost' => 80, 'unit_price' => 480, 'stock_qty' => 999],
            ['name' => 'Wash & Bag Service', 'sku' => 'WS-WS-1', 'category' => 'service', 'unit_cost' => 20, 'unit_price' => 95, 'stock_qty' => 999],
        ];
        foreach ($products as $product) {
            Product::query()->updateOrCreate(['sku' => $product['sku']], $product + ['unit' => 'each', 'is_active' => true]);
        }

        $customers = collect([
            ['name' => 'Tom Hughes', 'email' => 'tom@newportyc.org', 'phone' => '(401) 555-2201', 'company' => 'Newport Yacht Club', 'city' => 'Newport', 'state' => 'RI', 'zip' => '02840', 'address' => '110 Long Wharf'],
            ['name' => 'Grace Kim', 'email' => 'grace.kim@example.com', 'phone' => '(401) 555-2210', 'company' => null, 'city' => 'Middletown', 'state' => 'RI', 'zip' => '02842', 'address' => '99 Aquidneck Ave'],
            ['name' => 'Ben Ortiz', 'email' => 'ops@bristolcharters.ri', 'phone' => '(401) 555-2299', 'company' => 'Bristol Charters', 'city' => 'Bristol', 'state' => 'RI', 'zip' => '02809', 'address' => '1 Thames St'],
            ['name' => 'Clara Jensen', 'email' => 'clara.jensen@example.com', 'phone' => '(401) 555-2188', 'company' => null, 'city' => 'Jamestown', 'state' => 'RI', 'zip' => '02835', 'address' => '20 Ferry Wharf'],
            ['name' => 'Omar Farid', 'email' => 'omar@bayracingfleet.com', 'phone' => '(401) 555-2177', 'company' => 'Bay Racing Fleet', 'city' => 'Newport', 'state' => 'RI', 'zip' => '02840', 'address' => '5 Anchorage Way'],
        ])->map(fn ($c) => Customer::query()->updateOrCreate(['email' => $c['email']], $c));

        $projects = [
            ['customer' => 0, 'title' => 'Leech tape repair — NYC genoa', 'service_type' => 'repair', 'status' => 'scheduled', 'sq_ft' => 420, 'quoted_amount' => 480],
            ['customer' => 1, 'title' => 'UV cover — Kim furling 135', 'service_type' => 'uv', 'status' => 'in_progress', 'sq_ft' => 380, 'quoted_amount' => 620],
            ['customer' => 2, 'title' => 'Main recut — Bristol Charters', 'service_type' => 'recut', 'status' => 'quoted', 'sq_ft' => 510, 'quoted_amount' => 1450],
            ['customer' => 3, 'title' => 'Dodger window replace — Jensen', 'service_type' => 'canvas', 'status' => 'completed', 'sq_ft' => 0, 'quoted_amount' => 890, 'final_amount' => 870],
            ['customer' => 4, 'title' => 'Race fleet wash/bag — Bay Racing', 'service_type' => 'wash', 'status' => 'invoiced', 'sq_ft' => 0, 'quoted_amount' => 2100, 'final_amount' => 2050],
        ];

        $projectModels = [];
        foreach ($projects as $i => $p) {
            $customer = $customers[$p['customer']];
            $projectModels[] = Project::query()->updateOrCreate(
                ['job_number' => 'JOB-26'.str_pad((string) ($i + 1), 3, '0', STR_PAD_LEFT)],
                [
                    'customer_id' => $customer->id,
                    'title' => $p['title'],
                    'service_type' => $p['service_type'],
                    'status' => $p['status'],
                    'sq_ft' => $p['sq_ft'],
                    'quoted_amount' => $p['quoted_amount'],
                    'final_amount' => $p['final_amount'] ?? null,
                    'start_date' => now()->subDays(10 - $i)->toDateString(),
                    'site_address' => trim(($customer->address ?? '').', '.$customer->city.', '.$customer->state),
                    'notes' => 'Seeded demo job for Windstitch ERP.',
                ]
            );
        }

        foreach ([0, 1, 3, 4] as $idx) {
            $project = $projectModels[$idx];
            $invoice = Invoice::query()->updateOrCreate(
                ['invoice_number' => 'INV-26'.str_pad((string) ($idx + 1), 3, '0', STR_PAD_LEFT)],
                [
                    'customer_id' => $project->customer_id,
                    'project_id' => $project->id,
                    'issue_date' => now()->subDays(8 - $idx)->toDateString(),
                    'due_date' => now()->addDays(14)->toDateString(),
                    'subtotal' => $project->final_amount ?? $project->quoted_amount,
                    'tax' => round(($project->final_amount ?? $project->quoted_amount) * (7.00/100), 2),
                    'total' => round(($project->final_amount ?? $project->quoted_amount) * (1+7.00/100), 2),
                    'amount_paid' => in_array($project->status, ['completed', 'invoiced'], true) ? round(($project->final_amount ?? $project->quoted_amount) * (1+7.00/100), 2) : 0,
                    'status' => in_array($project->status, ['completed', 'invoiced'], true) ? 'paid' : 'sent',
                ]
            );

            if ($invoice->status === 'paid') {
                Payment::query()->updateOrCreate(
                    ['reference' => 'PMT-'.$invoice->invoice_number],
                    [
                        'invoice_id' => $invoice->id,
                        'amount' => $invoice->total,
                        'paid_at' => now()->subDays(3)->toDateString(),
                        'method' => 'card',
                        'notes' => 'Demo payment',
                    ]
                );
            }
        }

        Appointment::query()->updateOrCreate(
            ['title' => 'Sail drop quote — NYC genoa'],
            [
                'customer_id' => $customers[0]->id,
                'project_id' => $projectModels[0]->id,
                'type' => 'consult',
                'starts_at' => now()->addDays(1)->setTime(10, 0),
                'ends_at' => now()->addDays(1)->setTime(11, 0),
                'status' => 'scheduled',
                'location' => $customers[0]->address,
            ]
        );
        Appointment::query()->updateOrCreate(
            ['title' => 'UV fitting — Kim 135'],
            [
                'customer_id' => $customers[1]->id,
                'project_id' => $projectModels[1]->id,
                'type' => 'loft',
                'starts_at' => now()->addDays(2)->setTime(13, 0),
                'ends_at' => now()->addDays(2)->setTime(15, 0),
                'status' => 'confirmed',
                'location' => $customers[1]->address,
            ]
        );

        $posts = [
            [
                'title' => 'When a Patch Beats a New Sail',
                'excerpt' => 'Cloth life, shape, and load paths decide repair vs replace.',
                'cover' => 'https://images.unsplash.com/photo-1540946485063-a40bc277dc44?auto=format&fit=crop&w=1200&q=80',
                'body' => "Windstitch evaluates Newport race sails on the loft floor before quoting new inventory.",
            ],
            [
                'title' => 'UV Covers That Actually Survive July',
                'excerpt' => 'Stitching and cloth choice matter more than color.',
                'cover' => 'https://images.unsplash.com/photo-1569263979104-865ab7cd8d19?auto=format&fit=crop&w=1200&q=80',
                'body' => "We measure furling genoas carefully so covers do not chew leeches.",
            ],
            [
                'title' => 'Race-Week Repair Etiquette',
                'excerpt' => 'How to drop a sail Friday and still make Saturday.',
                'cover' => 'https://images.unsplash.com/photo-1544551763-77ef2d0cfc6c?auto=format&fit=crop&w=1200&q=80',
                'body' => "Priority slots and clear damage notes keep the loft moving when the Bay calendar is packed.",
            ],
        ];
        foreach ($posts as $post) {
            Post::query()->updateOrCreate(
                ['slug' => Str::slug($post['title'])],
                [
                    'title' => $post['title'],
                    'excerpt' => $post['excerpt'],
                    'body' => $post['body'],
                    'cover_image' => $post['cover'],
                    'is_published' => true,
                    'published_at' => now()->subDays(random_int(2, 20)),
                ]
            );
        }

        $articles = [
            ['category' => 'issues', 'title' => 'Seam opens along the leech after a blow', 'body' => "Inspect load tape and stitching. Windstitch restitches and reinforces before the next start."],
            ['category' => 'issues', 'title' => 'Mildew smell after winter storage', 'body' => "Wash, dry, and inspect before bagging. We document stains and weak panels."],
            ['category' => 'guides', 'title' => 'How to flake and bag a sail for loft drop', 'body' => "Dry the sail. Flake loosely. Note boat name and sail ID. Photo damage areas."],
            ['category' => 'guides', 'title' => 'From intake to pickup at Windstitch', 'body' => "Intake photo → quote → stitch → QA flake → notify pickup."],
            ['category' => 'admin', 'title' => 'Admin ERP quick start', 'body' => "Login at /admin with admin@example.com / password.
1. Add customers.
2. Create a sail job.
3. Schedule loft appointments.
4. Track cloth inventory.
5. Invoice and record payments.
6. Use AI Studio.
7. Update Settings."],
            ['category' => 'admin', 'title' => 'Roles: Admin, Manager, Staff', 'body' => "Admin: full ERP + settings + users.
Manager: jobs, inventory, invoices, scheduling.
Staff: loft-facing records."],
            ['category' => 'troubleshoot', 'title' => 'Cloth stock shows zero mid-season', 'body' => "Check open sail jobs holding reserved yards. Recount loft rolls."],
            ['category' => 'troubleshoot', 'title' => 'Chatbot giving demo answers only', 'body' => "Add OPENAI_API_KEY or GEMINI_API_KEY to .env, then clear config cache."],
        ];
        foreach ($articles as $article) {
            KnowledgeArticle::query()->updateOrCreate(
                ['slug' => Str::slug($article['title'])],
                [
                    'title' => $article['title'],
                    'category' => $article['category'],
                    'body' => $article['body'],
                    'is_published' => true,
                ]
            );
        }
    }
}
