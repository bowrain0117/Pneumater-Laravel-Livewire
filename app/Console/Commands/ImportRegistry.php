<?php

namespace App\Console\Commands;

use App\Enums\RegistryRoleType;
use App\Enums\RegistryType;
use App\Models\Registry;
use App\Models\User;
use Illuminate\Console\Command;

class ImportRegistry extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:registry {file_name} {role}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $file_name = $this->argument('file_name');
        $role = $this->argument('role');

        if (! file_exists($file_name)) {
            $this->error('File not found');

            return Command::FAILURE;
        }

        if (! in_array($role, [RegistryRoleType::CUSTOMER, RegistryRoleType::SUPPLIER])) {
            $this->error('Role not found');

            return Command::FAILURE;
        }

        $file = file_get_contents($file_name);

        foreach (json_decode($file, true) as $row) {
            $type = $row['Cod. destinatario Fatt. elettr.'] != '' ? RegistryType::COMPANY : RegistryType::PRIVATE;

            if ($type == RegistryType::PRIVATE) {
                $splitted = explode(' ', $row['Denominazione'], 2);
                if (count($splitted) == 2) {
                    $name = $splitted[0];
                    $surname = $splitted[1];
                    $denomination = null;
                } else {
                    $name = $row['Denominazione'];
                    $surname = '-';
                    $denomination = null;
                }
            } else {
                $denomination = $row['Denominazione'];
                $name = null;
                $surname = null;
            }

            Registry::create([
                'type' => $type,
                'role' => $role,
                'code' => $row['Cod.'],
                'fiscal_code' => $row['Codice fiscale'],
                'vat_number' => $row['Partita Iva'],
                'sdi' => $row['Cod. destinatario Fatt. elettr.'],
                'denomination' => $denomination,
                'name' => $name,
                'surname' => $surname,
                'address' => $row['Indirizzo'],
                'city' => $row['Città'],
                'postal_code' => $row['Cap'],
                'province' => $row['Prov.'],
                'region' => $row['Regione'],
                'nation' => $row['Nazione'],
                'phone' => $row['Tel.'],
                'cellular' => $row['Cell'],
                'email' => $row['e-mail'],
                'note' => $row['Note'],
                'created_by' => User::first()->id,
            ]);
        }

        return Command::SUCCESS;
    }
}
