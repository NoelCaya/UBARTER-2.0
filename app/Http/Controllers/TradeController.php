<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class TradeController extends Controller
{
    /**
     * Export trade history to CSV
     */
    public function export(Request $request)
    {
        $user = auth()->user();
        
        // Sample trade data - In a real app, this would be from the database
        $trades = [
            [
                'date' => '2026-05-04',
                'status' => 'Completed',
                'item_given' => 'Arduino Uno Kit',
                'item_received' => 'Biology Textbook',
                'trade_partner' => 'Maria Santos',
                'department' => 'ECE Dept',
                'waste_diverted' => '2.3 kg',
                'notes' => 'Both items verified'
            ],
            [
                'date' => '2026-05-03',
                'status' => 'Pending Confirmation',
                'item_given' => 'Graphing Calculator',
                'item_received' => 'Chemistry Lab Manual',
                'trade_partner' => 'James Reyes',
                'department' => 'ME Dept',
                'waste_diverted' => '1.8 kg',
                'notes' => 'Waiting for approval'
            ],
            [
                'date' => '2026-05-01',
                'status' => 'Completed',
                'item_given' => 'Nursing Textbook Set',
                'item_received' => 'Drawing Materials',
                'trade_partner' => 'Sofia Garcia',
                'department' => 'CAS Dept',
                'waste_diverted' => '3.2 kg',
                'notes' => '5 star reviews'
            ],
            [
                'date' => '2026-04-28',
                'status' => 'Cancelled',
                'item_given' => 'Laptop Bag',
                'item_received' => 'Phone Accessories',
                'trade_partner' => 'John Dela Cruz',
                'department' => 'ME Dept',
                'waste_diverted' => '0 kg',
                'notes' => 'Buyer withdrew'
            ],
            [
                'date' => '2026-04-25',
                'status' => 'Completed',
                'item_given' => 'USB Flash Drives (5x)',
                'item_received' => 'Programming Books',
                'trade_partner' => 'Alex Chen',
                'department' => 'ECE Dept',
                'waste_diverted' => '1.5 kg',
                'notes' => '5 star reviews'
            ]
        ];

        $filename = 'UBarter_Trade_History_' . date('Y-m-d') . '.csv';

        $response = new StreamedResponse(function () use ($trades, $user) {
            $file = fopen('php://output', 'w');

            // Header
            fputcsv($file, [
                'UBarter Trade History Export',
                'User: ' . $user->name,
                'Email: ' . $user->email,
                'Exported: ' . now()->format('Y-m-d H:i:s')
            ]);
            
            fputcsv($file, []); // Empty row for spacing
            
            // Column headers
            fputcsv($file, [
                'Date',
                'Status',
                'Item Given',
                'Item Received',
                'Trade Partner',
                'Department',
                'Waste Diverted',
                'Notes'
            ]);

            // Data rows
            foreach ($trades as $trade) {
                fputcsv($file, [
                    $trade['date'],
                    $trade['status'],
                    $trade['item_given'],
                    $trade['item_received'],
                    $trade['trade_partner'],
                    $trade['department'],
                    $trade['waste_diverted'],
                    $trade['notes']
                ]);
            }

            // Summary section
            fputcsv($file, []); // Empty row
            fputcsv($file, ['SUMMARY']);
            fputcsv($file, ['Total Trades', '24']);
            fputcsv($file, ['Completed', '24']);
            fputcsv($file, ['Total Items Given', '32']);
            fputcsv($file, ['Total Items Received', '28']);
            fputcsv($file, ['Total Waste Diverted', '42.3 kg']);

            fclose($file);
        });

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="' . $filename . '"');

        return $response;
    }
}
