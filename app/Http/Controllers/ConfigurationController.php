<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Configuration;

class ConfigurationController extends Controller
{
    public function edit()
    {
        $configuration = Configuration::firstOrFail(); // Obtém a primeira configuração existente

        return view('configurations.edit', compact('configuration'));
    }

    public function update(Request $request, Configuration $configuration)
    {
        $request->validate([
            'ticket_price' => 'required|numeric|min:0',
            'registered_customer_ticket_discount' => 'required|numeric|min:0|max:100',
        ]);

        $configuration->update([
            'ticket_price' => $request->ticket_price,
            'registered_customer_ticket_discount' => $request->registered_customer_ticket_discount,
        ]);

        return redirect()->route('configuration.edit')
                         ->with('success', 'Configurações atualizadas com sucesso!');
    }
}
