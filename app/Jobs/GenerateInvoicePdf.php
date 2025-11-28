<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Order;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\InvoiceMail;
use Illuminate\Queue\SerializesModels;

class GenerateInvoicePdf implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public readonly Order $order
    ) {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        $pdf = Pdf::loadView('pdf.invoice', ['order' => $this->order]);

        $filename = 'invoices/invoice_' . $this->order->id . '.pdf';

        $pdfOutput = $pdf->output();

        $stored = Storage::put($filename, $pdfOutput);
        if (!$stored) {
            throw new \RuntimeException("Failed to store invoice PDF for order ID {$this->order->id}");
        }

        Mail::to($this->order->user->email)
            ->send(new InvoiceMail($this->order, $pdfOutput));
    }
}
