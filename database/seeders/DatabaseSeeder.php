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
                'phone' => '(512) 555-0138',
            ]
        );
        $admin->syncRoles(['admin']);

        User::query()->updateOrCreate(
            ['email' => 'manager@skydatum.aero'],
            [
                'name' => 'Jordan Hale',
                'password' => Hash::make('password'),
                'role' => 'manager',
                'phone' => '(512) 555-0138',
            ]
        )->syncRoles(['manager']);

        User::query()->updateOrCreate(
            ['email' => 'pilot@skydatum.aero'],
            [
                'name' => 'Riley Campos',
                'password' => Hash::make('password'),
                'role' => 'staff',
                'phone' => '(512) 555-0138',
            ]
        )->syncRoles(['staff']);

        $settings = [
            'company_name' => 'SkyDatum Aerial Survey',
            'company_phone' => '(512) 555-0138',
            'company_email' => 'fly@skydatum.aero',
            'whatsapp' => '15125550138',
            'service_area' => 'Austin, Round Rock, San Marcos, Georgetown & Central Texas',
            'tax_rate' => '8.25',
        ];
        foreach ($settings as $key => $value) {
            Setting::setValue($key, $value);
        }

        $products = array (
  0 => 
  array (
    'name' => 'Topo Flight — under 20 ac',
    'sku' => 'UAV-TOP-20',
    'category' => 'mapping',
    'unit_cost' => 450,
    'unit_price' => 1450,
    'stock_qty' => 999,
    'unit' => 'flight',
  ),
  1 => 
  array (
    'name' => 'Topo Flight — 20–100 ac',
    'sku' => 'UAV-TOP-100',
    'category' => 'mapping',
    'unit_cost' => 900,
    'unit_price' => 3200,
    'stock_qty' => 999,
    'unit' => 'flight',
  ),
  2 => 
  array (
    'name' => 'Progress Ortho Package',
    'sku' => 'UAV-ORT-P',
    'category' => 'construction',
    'unit_cost' => 280,
    'unit_price' => 890,
    'stock_qty' => 999,
    'unit' => 'flight',
  ),
  3 => 
  array (
    'name' => 'Stockpile Volume Report',
    'sku' => 'UAV-VOL-1',
    'category' => 'volumetrics',
    'unit_cost' => 200,
    'unit_price' => 650,
    'stock_qty' => 999,
    'unit' => 'report',
  ),
  4 => 
  array (
    'name' => 'GCP Kit Deployment',
    'sku' => 'UAV-GCP-K',
    'category' => 'control',
    'unit_cost' => 120,
    'unit_price' => 350,
    'stock_qty' => 12,
    'unit' => 'kit',
  ),
  5 => 
  array (
    'name' => 'Corridor Mile Mapping',
    'sku' => 'UAV-COR-M',
    'category' => 'corridor',
    'unit_cost' => 180,
    'unit_price' => 520,
    'stock_qty' => 999,
    'unit' => 'mile',
  ),
  6 => 
  array (
    'name' => 'Propeller / Battery Pack',
    'sku' => 'UAV-PROP-B',
    'category' => 'equipment',
    'unit_cost' => 85,
    'unit_price' => 0,
    'stock_qty' => 30,
    'unit' => 'pack',
  ),
  7 => 
  array (
    'name' => 'Rush Processing 24h',
    'sku' => 'UAV-RUSH-1',
    'category' => 'processing',
    'unit_cost' => 150,
    'unit_price' => 450,
    'stock_qty' => 999,
    'unit' => 'job',
  ),
);
        foreach ($products as $product) {
            Product::query()->updateOrCreate(['sku' => $product['sku']], $product + ['is_active' => true]);
        }

        $customers = collect(array (
  0 => 
  array (
    'name' => 'Alex Rivera',
    'email' => 'alex@hillcountrycivil.com',
    'phone' => '(512) 555-2201',
    'company' => 'Hill Country Civil',
    'city' => 'Austin',
    'state' => 'TX',
    'zip' => '78701',
    'address' => '301 Congress Ave',
  ),
  1 => 
  array (
    'name' => 'Sam Ortiz',
    'email' => 'sam@capitolgc.com',
    'phone' => '(512) 555-2210',
    'company' => 'Capitol General Contractors',
    'city' => 'Austin',
    'state' => 'TX',
    'zip' => '78745',
    'address' => '4425 S Mopac Expy',
  ),
  2 => 
  array (
    'name' => 'Taylor Kim',
    'email' => 'taylor@roundrockpw.gov',
    'phone' => '(512) 555-2299',
    'company' => 'City of Round Rock Public Works',
    'city' => 'Round Rock',
    'state' => 'TX',
    'zip' => '78664',
    'address' => '221 E Main St',
  ),
  3 => 
  array (
    'name' => 'Casey Boone',
    'email' => 'casey.boone@example.com',
    'phone' => '(512) 555-2188',
    'company' => NULL,
    'city' => 'San Marcos',
    'state' => 'TX',
    'zip' => '78666',
    'address' => '630 E Hopkins St',
  ),
  4 => 
  array (
    'name' => 'Morgan Ellis',
    'email' => 'morgan@texagg.com',
    'phone' => '(512) 555-2177',
    'company' => 'TexAgg Materials',
    'city' => 'Georgetown',
    'state' => 'TX',
    'zip' => '78626',
    'address' => '1500 N IH-35',
  ),
))->map(fn ($c) => Customer::query()->updateOrCreate(['email' => $c['email']], $c));

        $projects = array (
  0 => 
  array (
    'customer' => 0,
    'title' => 'Subdivision topo — 85 acres',
    'service_type' => 'topo',
    'status' => 'scheduled',
    'sq_ft' => 85,
    'quoted_amount' => 4800,
  ),
  1 => 
  array (
    'customer' => 1,
    'title' => 'Weekly progress orthos — campus',
    'service_type' => 'ortho',
    'status' => 'in_progress',
    'sq_ft' => 40,
    'quoted_amount' => 7200,
  ),
  2 => 
  array (
    'customer' => 2,
    'title' => 'Arterial corridor ROW mosaic',
    'service_type' => 'corridor',
    'status' => 'quoted',
    'sq_ft' => 6,
    'quoted_amount' => 3900,
  ),
  3 => 
  array (
    'customer' => 3,
    'title' => 'Residential as-built aerial',
    'service_type' => 'asbuilt',
    'status' => 'completed',
    'sq_ft' => 2,
    'quoted_amount' => 950,
    'final_amount' => 950,
  ),
  4 => 
  array (
    'customer' => 4,
    'title' => 'Quarry stockpile volumetrics month',
    'service_type' => 'volume',
    'status' => 'invoiced',
    'sq_ft' => 0,
    'quoted_amount' => 2400,
    'final_amount' => 2550,
  ),
);

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
                    'notes' => 'Seeded demo aerial survey mission for SkyDatum ERP. sq_ft stores acres where relevant.',
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
                    'tax' => round(($project->final_amount ?? $project->quoted_amount) * 0.0825, 2),
                    'total' => round(($project->final_amount ?? $project->quoted_amount) * (1 + 0.0825), 2),
                    'amount_paid' => in_array($project->status, ['completed', 'invoiced'], true) ? round(($project->final_amount ?? $project->quoted_amount) * (1 + 0.0825), 2) : 0,
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
                        'method' => 'ach',
                        'notes' => 'Demo payment',
                    ]
                );
            }
        }

        Appointment::query()->updateOrCreate(
            ['title' => 'Topo flight — Hill Country 85ac'],
            [
                'customer_id' => $customers[0]->id,
                'project_id' => $projectModels[0]->id,
                'type' => 'flight',
                'starts_at' => now()->addDays(2)->setTime(8, 0),
                'ends_at' => now()->addDays(2)->setTime(11, 0),
                'status' => 'scheduled',
                'location' => $customers[0]->address,
            ]
        );
        Appointment::query()->updateOrCreate(
            ['title' => 'Stockpile flight — TexAgg'],
            [
                'customer_id' => $customers[4]->id,
                'project_id' => $projectModels[4]->id,
                'type' => 'flight',
                'starts_at' => now()->addDays(5)->setTime(7, 0),
                'ends_at' => now()->addDays(5)->setTime(9, 0),
                'status' => 'confirmed',
                'location' => $customers[4]->address,
            ]
        );

        $posts = array (
  0 => 
  array (
    'title' => 'GCPs Still Matter for Austin Drone Topo',
    'excerpt' => 'RTK helps — independent ground control keeps civil CAD honest when checkpoints fail.',
    'cover' => 'https://images.unsplash.com/photo-1527979809429-b4bb5c0c0f1c?auto=format&fit=crop&w=1400&q=80',
    'body' => 'SkyDatum deploys GCPs on every design-grade flight. Pretty orthos without checkpoints are marketing — contours for earthwork need survey discipline.',
  ),
  1 => 
  array (
    'title' => 'Progress Orthos Your Superintendents Will Actually Open',
    'excerpt' => 'Same CRS, same altitude, same time of day — the trio that makes week-over-week comparisons useful.',
    'cover' => 'https://images.unsplash.com/photo-1531834685032-c34bfa9ee8b2?auto=format&fit=crop&w=1400&q=80',
    'body' => 'We lock flight plans so Capitol GC crews compare apples to apples. Change detection fails when every flight is a one-off experiment.',
  ),
  2 => 
  array (
    'title' => 'Stockpile Volumes Without the Guesswork',
    'excerpt' => 'Base surfaces, toe breaks, and audit notes — what materials yards should demand in a report.',
    'cover' => 'https://images.unsplash.com/photo-1565008576549-57569a49371d?auto=format&fit=crop&w=1400&q=80',
    'body' => 'Volumetrics are only as good as the base you subtract. SkyDatum documents assumptions so TexAgg and similar yards can defend inventories.',
  ),
);
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

        $articles = array (
  0 => 
  array (
    'category' => 'issues',
    'title' => 'Flight scrubbed — wind over limits',
    'body' => 'Do not force the flight. Reschedule within weather window. Notify the client same day. Keep GCP kit staged if control is already set.',
  ),
  1 => 
  array (
    'category' => 'issues',
    'title' => 'Checkpoint RMS exceeds tolerance',
    'body' => 'Review GCP survey. Reprocess with corrected control. Refly only if residual errors remain. Document QA in the project notes.',
  ),
  2 => 
  array (
    'category' => 'guides',
    'title' => 'How to prepare a site for a drone topo',
    'body' => 'Clear airspace coordination. Mark GCPs if SkyDatum is not setting them. Unlock gates. Share CAD base and CRS. Keep active equipment clear of flight lines.',
  ),
  3 => 
  array (
    'category' => 'guides',
    'title' => 'Aerial survey timeline from book to deliverable',
    'body' => 'Day 0: Book & weather check.
Day 1: Flight + GCP.
Days 2–4: Processing.
Closeout: Contours/ortho/volume package + invoice.',
  ),
  4 => 
  array (
    'category' => 'admin',
    'title' => 'Admin ERP quick start',
    'body' => 'Login at /admin with admin@example.com / password.
1. Add clients.
2. Create flight projects.
3. Schedule flights.
4. Invoice and record payments.
5. Use AI Studio.
6. Update Settings.',
  ),
  5 => 
  array (
    'category' => 'admin',
    'title' => 'Roles: Admin, Manager, Staff',
    'body' => 'Admin: full ERP + settings + users.
Manager: projects, inventory, invoices, scheduling.
Staff: pilot logs and appointment updates.',
  ),
  6 => 
  array (
    'category' => 'troubleshoot',
    'title' => 'Battery brownout mid-mission',
    'body' => 'Land immediately. Swap packs. Resume from last complete flight line. Log the event and inspect props before next hop.',
  ),
  7 => 
  array (
    'category' => 'troubleshoot',
    'title' => 'Chatbot giving demo answers only',
    'body' => 'Add OPENAI_API_KEY or GEMINI_API_KEY to .env for live model replies.',
  ),
);
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