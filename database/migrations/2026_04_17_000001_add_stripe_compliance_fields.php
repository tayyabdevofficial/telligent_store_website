<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('service_packages', function (Blueprint $table) {
            $table->text('description')->nullable()->after('service_type');
            $table->string('delivery_timeline')->nullable()->after('description');
        });

        Schema::table('payment_links', function (Blueprint $table) {
            $table->text('description')->nullable()->after('title');
        });

        DB::table('service_packages')->whereNull('description')->update([
            'description' => DB::raw("CONCAT(name, ' includes ', LOWER(service_type), ' delivery for the selected platform. Review the package details on the storefront before checkout.')"),
        ]);

        DB::table('service_packages')->whereNull('delivery_timeline')->update([
            'delivery_timeline' => 'Delivery typically starts within 24 hours and completes within 3 to 7 business days.',
        ]);

        DB::table('payment_links')->whereNull('description')->update([
            'description' => 'Custom billed digital service request. Use this payment link only after reviewing the quoted service scope, timeline, and deliverables with support.',
        ]);
    }

    public function down(): void
    {
        Schema::table('payment_links', function (Blueprint $table) {
            $table->dropColumn('description');
        });

        Schema::table('service_packages', function (Blueprint $table) {
            $table->dropColumn(['description', 'delivery_timeline']);
        });
    }
};
