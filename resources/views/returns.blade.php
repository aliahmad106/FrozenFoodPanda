@extends('layouts.app')

@section('title', 'Return Policy')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h1 class="mb-0">Return Policy</h1>
                </div>
                <div class="card-body p-4">
                    <div class="mb-4">
                        <p class="text-muted">Last updated: May 1, 2025</p>
                    </div>

                    <div class="mb-4">
                        <p>At FrozenFoodPanda, we are committed to ensuring your satisfaction with every purchase. We understand that sometimes a product may not meet your expectations or may arrive damaged. This Return Policy outlines our procedures for returns, refunds, and exchanges.</p>
                    </div>

                    <div class="mb-4">
                        <h4>Return Eligibility</h4>
                        <p>You may return products purchased from FrozenFoodPanda under the following conditions:</p>
                        <ul>
                            <li><strong>Damaged or Defective Products:</strong> If you receive a product that is damaged or defective, you may return it for a full refund or replacement.</li>
                            <li><strong>Incorrect Products:</strong> If you receive a product that is different from what you ordered, you may return it for a full refund or the correct product.</li>
                            <li><strong>Quality Issues:</strong> If you are not satisfied with the quality of a product, you may return it for a refund or exchange.</li>
                        </ul>
                    </div>

                    <div class="mb-4">
                        <h4>Return Timeframe</h4>
                        <p>To be eligible for a return, you must contact our customer service team within:</p>
                        <ul>
                            <li><strong>24 hours</strong> of delivery for any issues related to temperature, thawing, or spoilage</li>
                            <li><strong>48 hours</strong> of delivery for any other issues with the product</li>
                        </ul>
                        <p>Due to the perishable nature of our products, we cannot accept returns after these timeframes.</p>
                    </div>

                    <div class="mb-4">
                        <h4>Non-Returnable Items</h4>
                        <p>The following items cannot be returned:</p>
                        <ul>
                            <li>Products that have been opened, partially consumed, or show signs of tampering</li>
                            <li>Products that have been thawed and refrozen due to improper handling after delivery</li>
                            <li>Products that were properly delivered but left unattended by the customer for an extended period</li>
                            <li>Special order or custom products specifically prepared for you</li>
                        </ul>
                    </div>

                    <div class="mb-4">
                        <h4>Return Process</h4>
                        <p>To initiate a return, please follow these steps:</p>
                        <ol>
                            <li>Contact our customer service team within the specified timeframe by phone or email</li>
                            <li>Provide your order number, the items you wish to return, and the reason for the return</li>
                            <li>Our team will review your request and provide instructions for the return process</li>
                            <li>For approved returns, we may:
                                <ul>
                                    <li>Schedule a pickup of the product</li>
                                    <li>Request photos of the damaged or defective product</li>
                                    <li>Process an immediate refund without requiring the product to be returned (for certain cases)</li>
                                </ul>
                            </li>
                        </ol>
                    </div>

                    <div class="mb-4">
                        <h4>Refunds</h4>
                        <p>Once your return is received and inspected, we will process your refund. Refunds will be issued to the original payment method used for the purchase.</p>
                        <p><strong>Refund Timeline:</strong></p>
                        <ul>
                            <li>Credit/Debit Card: 3-5 business days after the refund is processed</li>
                            <li>Bank Transfer: 5-7 business days after the refund is processed</li>
                            <li>Store Credit: Immediately after the refund is processed</li>
                        </ul>
                        <p>Shipping charges are non-refundable unless the return is due to our error (such as sending the wrong product or a damaged product).</p>
                    </div>

                    <div class="mb-4">
                        <h4>Exchanges</h4>
                        <p>If you prefer to exchange a product rather than receive a refund, we will process the exchange based on product availability. If the replacement product costs more than the original purchase, you will need to pay the difference. If it costs less, we will refund the difference.</p>
                    </div>

                    <div class="mb-4">
                        <h4>Damaged During Delivery</h4>
                        <p>If your order arrives damaged or with temperature issues:</p>
                        <ol>
                            <li>Take photos of the damaged packaging and/or products</li>
                            <li>Contact our customer service team immediately</li>
                            <li>Do not consume any products that appear to have thawed or spoiled</li>
                        </ol>
                        <p>We take the quality and safety of our products seriously and will address these issues promptly.</p>
                    </div>

                    <div class="mb-4">
                        <h4>Changes to This Return Policy</h4>
                        <p>We may update our Return Policy from time to time. We will notify you of any changes by posting the new Return Policy on this page and updating the "Last updated" date.</p>
                    </div>

                    <div class="mb-4">
                        <h4>Contact Us</h4>
                        <p>If you have any questions about our Return Policy, please contact our customer service team:</p>
                        <ul>
                            <li>Email: returns@frozenfoodpanda.com</li>
                            <li>Phone: (555) 123-4567</li>
                            <li>Hours: Monday to Friday, 9 AM to 6 PM</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection