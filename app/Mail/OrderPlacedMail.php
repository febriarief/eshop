<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderPlacedMail extends Mailable
{
    use Queueable, SerializesModels;

    public Order $order;
    public array $orderDetails;

    /**
     * Create a new message instance.
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
        $this->orderDetails = [];
        foreach ($order->detail as $k => $detail) {
            $this->orderDetails[$k]['product_name']  = $detail->product_name;
            $this->orderDetails[$k]['product_image'] = "data:image/png;base64," . base64_encode(file_get_contents(storage_path('app/public/' . $detail->product_image)));
            $this->orderDetails[$k]['qty']           = $detail->qty;
            $this->orderDetails[$k]['total']         = $detail->total;
        }
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Order Placed',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.order-placed',
            with: [
                'order' => $this->order,
                'orderDetails' => $this->orderDetails
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
