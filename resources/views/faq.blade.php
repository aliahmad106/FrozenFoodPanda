@extends('layouts.app')

@section('title', 'Frequently Asked Questions')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h1 class="mb-0">Frequently Asked Questions</h1>
                </div>
                <div class="card-body p-4">
                    <div class="mb-4">
                        <p>Find answers to the most common questions about FrozenFoodPanda's products, ordering process, delivery, and more.</p>
                    </div>

                    <!-- General Questions -->
                    <div class="mb-5">
                        <h3 class="border-bottom pb-2 mb-4">General Questions</h3>
                        
                        <div class="accordion" id="accordionGeneral">
                            <div class="accordion-item border mb-3 rounded">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                        What is FrozenFoodPanda?
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionGeneral">
                                    <div class="accordion-body">
                                        FrozenFoodPanda is an online marketplace specializing in high-quality frozen foods. We offer a wide selection of frozen meals, ingredients, desserts, and more, delivered directly to your doorstep in temperature-controlled packaging to ensure freshness and quality.
                                    </div>
                                </div>
                            </div>
                            
                            <div class="accordion-item border mb-3 rounded">
                                <h2 class="accordion-header" id="headingTwo">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        Do I need to create an account to place an order?
                                    </button>
                                </h2>
                                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionGeneral">
                                    <div class="accordion-body">
                                        Yes, you need to create an account to place an order. Creating an account allows you to track your orders, save your delivery information, and make future purchases more conveniently. The registration process is simple and only takes a few minutes.
                                    </div>
                                </div>
                            </div>
                            
                            <div class="accordion-item border mb-3 rounded">
                                <h2 class="accordion-header" id="headingThree">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                        How do I contact customer service?
                                    </button>
                                </h2>
                                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionGeneral">
                                    <div class="accordion-body">
                                        You can contact our customer service team through several channels:
                                        <ul>
                                            <li>Email: support@frozenfoodpanda.com</li>
                                            <li>Phone: (555) 123-4567 (Monday to Friday, 9 AM to 6 PM)</li>
                                            <li>Contact form on our website</li>
                                            <li>Live chat (available during business hours)</li>
                                        </ul>
                                        We aim to respond to all inquiries within 24 hours.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Products & Ordering -->
                    <div class="mb-5">
                        <h3 class="border-bottom pb-2 mb-4">Products & Ordering</h3>
                        
                        <div class="accordion" id="accordionProducts">
                            <div class="accordion-item border mb-3 rounded">
                                <h2 class="accordion-header" id="headingFour">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                        How are your products kept frozen during delivery?
                                    </button>
                                </h2>
                                <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionProducts">
                                    <div class="accordion-body">
                                        We use specialized temperature-controlled packaging to ensure our products remain frozen during transit. Our packaging includes insulated boxes, dry ice or gel packs (depending on the product), and protective inner packaging. This system is designed to keep products frozen for up to 48 hours after dispatch, ensuring they arrive at your doorstep in perfect condition.
                                    </div>
                                </div>
                            </div>
                            
                            <div class="accordion-item border mb-3 rounded">
                                <h2 class="accordion-header" id="headingFive">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                        What if a product is out of stock?
                                    </button>
                                </h2>
                                <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#accordionProducts">
                                    <div class="accordion-body">
                                        If a product is out of stock, it will be marked as such on our website. You can choose to be notified when the product becomes available again by clicking the "Notify Me" button on the product page. We regularly restock our inventory, so most products are typically available again within a few days.
                                    </div>
                                </div>
                            </div>
                            
                            <div class="accordion-item border mb-3 rounded">
                                <h2 class="accordion-header" id="headingSix">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                        Can I modify or cancel my order after it's placed?
                                    </button>
                                </h2>
                                <div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingSix" data-bs-parent="#accordionProducts">
                                    <div class="accordion-body">
                                        You can modify or cancel your order within 1 hour of placing it, provided it hasn't been processed yet. To do so, log into your account, go to "Order History," select the order you wish to modify or cancel, and follow the instructions. If more than 1 hour has passed or if your order has already been processed, please contact our customer service team immediately for assistance.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Delivery & Shipping -->
                    <div class="mb-5">
                        <h3 class="border-bottom pb-2 mb-4">Delivery & Shipping</h3>
                        
                        <div class="accordion" id="accordionDelivery">
                            <div class="accordion-item border mb-3 rounded">
                                <h2 class="accordion-header" id="headingSeven">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
                                        How much does shipping cost?
                                    </button>
                                </h2>
                                <div id="collapseSeven" class="accordion-collapse collapse" aria-labelledby="headingSeven" data-bs-parent="#accordionDelivery">
                                    <div class="accordion-body">
                                        Shipping costs vary based on your location, order size, and delivery method. Standard delivery typically costs between $5-$10. Orders over $50 qualify for free standard delivery within our service areas. The exact shipping cost will be calculated and displayed at checkout before you complete your purchase.
                                    </div>
                                </div>
                            </div>
                            
                            <div class="accordion-item border mb-3 rounded">
                                <h2 class="accordion-header" id="headingEight">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEight" aria-expanded="false" aria-controls="collapseEight">
                                        How long will it take to receive my order?
                                    </button>
                                </h2>
                                <div id="collapseEight" class="accordion-collapse collapse" aria-labelledby="headingEight" data-bs-parent="#accordionDelivery">
                                    <div class="accordion-body">
                                        Delivery times depend on your location and the shipping method you choose:
                                        <ul>
                                            <li><strong>Standard Delivery:</strong> 24-48 hours</li>
                                            <li><strong>Express Delivery:</strong> Same-day delivery for orders placed before 12 PM (available in select areas)</li>
                                            <li><strong>Scheduled Delivery:</strong> Choose your preferred delivery date and time window</li>
                                        </ul>
                                        You'll receive an estimated delivery time at checkout, and we'll send you tracking information once your order is dispatched.
                                    </div>
                                </div>
                            </div>
                            
                            <div class="accordion-item border mb-3 rounded">
                                <h2 class="accordion-header" id="headingNine">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseNine" aria-expanded="false" aria-controls="collapseNine">
                                        What if I'm not home when my delivery arrives?
                                    </button>
                                </h2>
                                <div id="collapseNine" class="accordion-collapse collapse" aria-labelledby="headingNine" data-bs-parent="#accordionDelivery">
                                    <div class="accordion-body">
                                        During checkout, you can provide specific delivery instructions for when you're not home. Our delivery personnel will follow these instructions if possible. If no instructions are provided and no one is available to receive the order, the delivery person will attempt to find a safe place to leave your package. If this isn't possible, they will return the package to our facility, and we'll contact you to arrange redelivery (additional charges may apply).
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Returns & Refunds -->
                    <div class="mb-5">
                        <h3 class="border-bottom pb-2 mb-4">Returns & Refunds</h3>
                        
                        <div class="accordion" id="accordionReturns">
                            <div class="accordion-item border mb-3 rounded">
                                <h2 class="accordion-header" id="headingTen">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTen" aria-expanded="false" aria-controls="collapseTen">
                                        What is your return policy?
                                    </button>
                                </h2>
                                <div id="collapseTen" class="accordion-collapse collapse" aria-labelledby="headingTen" data-bs-parent="#accordionReturns">
                                    <div class="accordion-body">
                                        Due to the perishable nature of our products, we have a specific return policy. You can return products if they are damaged, defective, or incorrect. You must contact our customer service team within 24 hours of delivery for temperature-related issues or within 48 hours for other issues. Please refer to our <a href="{{ url('/returns') }}">Return Policy</a> for complete details.
                                    </div>
                                </div>
                            </div>
                            
                            <div class="accordion-item border mb-3 rounded">
                                <h2 class="accordion-header" id="headingEleven">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEleven" aria-expanded="false" aria-controls="collapseEleven">
                                        How do I request a refund?
                                    </button>
                                </h2>
                                <div id="collapseEleven" class="accordion-collapse collapse" aria-labelledby="headingEleven" data-bs-parent="#accordionReturns">
                                    <div class="accordion-body">
                                        To request a refund, contact our customer service team within the timeframes specified in our Return Policy. Provide your order number and details about the issue. Our team will review your request and guide you through the refund process. Refunds are typically processed within 3-5 business days and will be issued to your original payment method.
                                    </div>
                                </div>
                            </div>
                            
                            <div class="accordion-item border mb-3 rounded">
                                <h2 class="accordion-header" id="headingTwelve">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwelve" aria-expanded="false" aria-controls="collapseTwelve">
                                        What if my order arrives thawed or damaged?
                                    </button>
                                </h2>
                                <div id="collapseTwelve" class="accordion-collapse collapse" aria-labelledby="headingTwelve" data-bs-parent="#accordionReturns">
                                    <div class="accordion-body">
                                        If your order arrives thawed or damaged, do not consume the products. Take photos of the damaged packaging and/or products and contact our customer service team immediately. We take quality and safety seriously and will address these issues promptly. Depending on the situation, we will offer a refund or replacement.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Account & Payment -->
                    <div class="mb-5">
                        <h3 class="border-bottom pb-2 mb-4">Account & Payment</h3>
                        
                        <div class="accordion" id="accordionAccount">
                            <div class="accordion-item border mb-3 rounded">
                                <h2 class="accordion-header" id="headingThirteen">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThirteen" aria-expanded="false" aria-controls="collapseThirteen">
                                        What payment methods do you accept?
                                    </button>
                                </h2>
                                <div id="collapseThirteen" class="accordion-collapse collapse" aria-labelledby="headingThirteen" data-bs-parent="#accordionAccount">
                                    <div class="accordion-body">
                                        We accept the following payment methods:
                                        <ul>
                                            <li>Credit/Debit Cards (Visa, Mastercard, American Express)</li>
                                            <li>Bank Transfers</li>
                                            <li>EasyPaisa</li>
                                            <li>JazzCash</li>
                                            <li>Cash on Delivery (COD)</li>
                                        </ul>
                                        All online payments are processed securely through our payment gateway.
                                    </div>
                                </div>
                            </div>
                            
                            <div class="accordion-item border mb-3 rounded">
                                <h2 class="accordion-header" id="headingFourteen">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFourteen" aria-expanded="false" aria-controls="collapseFourteen">
                                        Is my payment information secure?
                                    </button>
                                </h2>
                                <div id="collapseFourteen" class="accordion-collapse collapse" aria-labelledby="headingFourteen" data-bs-parent="#accordionAccount">
                                    <div class="accordion-body">
                                        Yes, we take the security of your payment information very seriously. Our website uses SSL encryption to protect your data during transmission. We do not store your complete credit card information on our servers. All payment processing is handled by secure, PCI-compliant payment processors.
                                    </div>
                                </div>
                            </div>
                            
                            <div class="accordion-item border mb-3 rounded">
                                <h2 class="accordion-header" id="headingFifteen">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFifteen" aria-expanded="false" aria-controls="collapseFifteen">
                                        How do I update my account information?
                                    </button>
                                </h2>
                                <div id="collapseFifteen" class="accordion-collapse collapse" aria-labelledby="headingFifteen" data-bs-parent="#accordionAccount">
                                    <div class="accordion-body">
                                        To update your account information:
                                        <ol>
                                            <li>Log in to your account</li>
                                            <li>Click on "My Profile" or "Account Settings"</li>
                                            <li>Update your information as needed</li>
                                            <li>Click "Save Changes"</li>
                                        </ol>
                                        You can update your name, email address, phone number, delivery addresses, and payment methods through your account settings.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-5">
                        <h4>Still have questions?</h4>
                        <p>If you couldn't find the answer to your question, please contact our customer service team:</p>
                        <ul>
                            <li>Email: support@frozenfoodpanda.com</li>
                            <li>Phone: (555) 123-4567</li>
                            <li>Hours: Monday to Friday, 9 AM to 6 PM</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .accordion-button:not(.collapsed) {
        background-color: rgba(0, 136, 204, 0.1);
        color: var(--primary-color);
    }
    
    .accordion-button:focus {
        box-shadow: none;
        border-color: rgba(0, 136, 204, 0.25);
    }
    
    .accordion-item {
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
    }
</style>
@endsection