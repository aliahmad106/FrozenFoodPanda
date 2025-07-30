@extends('layouts.app')

@section('title', 'Shipping Policy')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h1 class="mb-0">Shipping Policy</h1>
                </div>
                <div class="card-body p-4">
                    <div class="mb-4">
                        <p class="text-muted">Last updated: May 1, 2025</p>
                    </div>

                    <div class="mb-4">
                        <p>At FrozenFoodPanda, we understand the importance of timely and proper delivery of frozen food products. This Shipping Policy outlines our procedures for shipping, delivery timeframes, and handling of your orders.</p>
                    </div>

                    <div class="mb-4">
                        <h4>Shipping Methods</h4>
                        <p>We offer the following shipping methods to ensure your frozen food arrives in perfect condition:</p>
                        <ul>
                            <li><strong>Standard Delivery:</strong> Delivery within 24-48 hours (available for all local areas)</li>
                            <li><strong>Express Delivery:</strong> Same-day delivery for orders placed before 12 PM (available in select areas)</li>
                            <li><strong>Scheduled Delivery:</strong> Choose a specific delivery date and time window (subject to availability)</li>
                        </ul>
                    </div>

                    <div class="mb-4">
                        <h4>Shipping Costs</h4>
                        <p>Our shipping costs are calculated based on:</p>
                        <ul>
                            <li>Your delivery location</li>
                            <li>The weight and volume of your order</li>
                            <li>Your selected delivery method</li>
                        </ul>
                        <p>Shipping costs will be calculated and displayed at checkout before payment is processed.</p>
                        <p><strong>Free Shipping:</strong> Orders over $50 qualify for free standard delivery within our service areas.</p>
                    </div>

                    <div class="mb-4">
                        <h4>Delivery Areas</h4>
                        <p>We currently deliver to the following areas:</p>
                        <ul>
                            <li>All major cities and surrounding suburbs</li>
                            <li>Select rural areas (subject to availability)</li>
                        </ul>
                        <p>To check if we deliver to your area, enter your postal code on our website before placing an order.</p>
                    </div>

                    <div class="mb-4">
                        <h4>Temperature-Controlled Packaging</h4>
                        <p>All our frozen food products are shipped in specialized temperature-controlled packaging to ensure they remain frozen during transit. Our packaging includes:</p>
                        <ul>
                            <li>Insulated boxes</li>
                            <li>Dry ice or gel packs (depending on the product)</li>
                            <li>Protective inner packaging to prevent damage</li>
                        </ul>
                        <p>Our packaging is designed to keep products frozen for up to 48 hours after dispatch.</p>
                    </div>

                    <div class="mb-4">
                        <h4>Order Tracking</h4>
                        <p>Once your order has been dispatched, you will receive:</p>
                        <ul>
                            <li>A dispatch confirmation email</li>
                            <li>A tracking number (where applicable)</li>
                            <li>Estimated delivery time</li>
                        </ul>
                        <p>You can track your order at any time by logging into your account on our website or using the tracking link provided in your dispatch confirmation email.</p>
                    </div>

                    <div class="mb-4">
                        <h4>Delivery Instructions</h4>
                        <p>You can provide specific delivery instructions during checkout, such as:</p>
                        <ul>
                            <li>Where to leave the package if you're not home</li>
                            <li>Security codes or access information</li>
                            <li>Preferred delivery time windows</li>
                        </ul>
                        <p>Our delivery personnel will make every effort to follow your instructions.</p>
                    </div>

                    <div class="mb-4">
                        <h4>Failed Deliveries</h4>
                        <p>If we are unable to deliver your order due to:</p>
                        <ul>
                            <li>No one available to receive the order</li>
                            <li>Incorrect delivery address</li>
                            <li>Inability to access the delivery location</li>
                        </ul>
                        <p>We will attempt to contact you to arrange an alternative delivery time or return the order to our facility. Additional delivery charges may apply for redelivery.</p>
                    </div>

                    <div class="mb-4">
                        <h4>Receiving Your Order</h4>
                        <p>Upon receiving your order:</p>
                        <ul>
                            <li>Inspect the package for any signs of damage</li>
                            <li>Check that all items are included and in good condition</li>
                            <li>Transfer frozen items to your freezer immediately</li>
                        </ul>
                        <p>If there are any issues with your delivery, please contact our customer service team within 24 hours.</p>
                    </div>

                    <div class="mb-4">
                        <h4>Changes to This Shipping Policy</h4>
                        <p>We may update our Shipping Policy from time to time. We will notify you of any changes by posting the new Shipping Policy on this page and updating the "Last updated" date.</p>
                    </div>

                    <div class="mb-4">
                        <h4>Contact Us</h4>
                        <p>If you have any questions about our Shipping Policy, please contact our customer service team:</p>
                        <ul>
                            <li>Email: shipping@frozenfoodpanda.com</li>
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