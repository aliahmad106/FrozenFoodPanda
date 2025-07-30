@extends('layouts.app')

@section('title', 'About Us')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h1 class="mb-0">About FrozenFoodPanda</h1>
                </div>
                <div class="card-body p-4">
                    <div class="row align-items-center mb-5">
                        <div class="col-lg-6 mb-4 mb-lg-0">
                            <h2>Our Story</h2>
                            <p>Founded in 2023, FrozenFoodPanda was born from a simple idea: to make high-quality frozen foods accessible to everyone. Our founder, Sarah Chen, noticed a gap in the market for premium frozen foods that didn't compromise on taste or nutrition.</p>
                            <p>What started as a small operation delivering handpicked frozen meals to local neighborhoods has grown into a comprehensive online marketplace offering a wide range of frozen products from trusted suppliers and our own exclusive line.</p>
                            <p>Today, FrozenFoodPanda serves thousands of customers nationwide, bringing convenience and quality to freezers everywhere.</p>
                        </div>
                        <div class="col-lg-6">
                            <img src="https://images.unsplash.com/photo-1606914501449-5a96b6ce24ca?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80" alt="Our Story" class="img-fluid rounded shadow-sm">
                        </div>
                    </div>
                    
                    <div class="row align-items-center mb-5 flex-lg-row-reverse">
                        <div class="col-lg-6 mb-4 mb-lg-0">
                            <h2>Our Mission</h2>
                            <p>At FrozenFoodPanda, our mission is to revolutionize the way people think about and consume frozen food. We believe that frozen doesn't mean compromising on quality, taste, or nutrition.</p>
                            <p>We're committed to:</p>
                            <ul>
                                <li>Sourcing the highest quality products from trusted suppliers</li>
                                <li>Ensuring proper freezing techniques to preserve flavor and nutrients</li>
                                <li>Providing exceptional customer service and reliable delivery</li>
                                <li>Offering a diverse range of options to suit all dietary needs and preferences</li>
                                <li>Reducing food waste through proper portioning and extended shelf life</li>
                            </ul>
                        </div>
                        <div class="col-lg-6">
                            <img src="https://images.unsplash.com/photo-1553546895-531931aa1aa8?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80" alt="Our Mission" class="img-fluid rounded shadow-sm">
                        </div>
                    </div>
                    
                    <div class="row mb-5">
                        <div class="col-12">
                            <h2 class="text-center mb-4">Why Choose FrozenFoodPanda?</h2>
                            <div class="row">
                                <div class="col-md-4 mb-4">
                                    <div class="feature-card h-100">
                                        <div class="feature-icon">
                                            <i class="fas fa-medal"></i>
                                        </div>
                                        <h4>Premium Quality</h4>
                                        <p>We carefully select each product in our inventory, ensuring only the best makes it to your freezer. Our quality standards are never compromised.</p>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-4">
                                    <div class="feature-card h-100">
                                        <div class="feature-icon">
                                            <i class="fas fa-truck-fast"></i>
                                        </div>
                                        <h4>Fast Delivery</h4>
                                        <p>Our specialized delivery system ensures your frozen foods arrive at your doorstep in perfect condition, with temperature-controlled packaging.</p>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-4">
                                    <div class="feature-card h-100">
                                        <div class="feature-icon">
                                            <i class="fas fa-leaf"></i>
                                        </div>
                                        <h4>Sustainability</h4>
                                        <p>We're committed to reducing our environmental footprint through eco-friendly packaging, optimized delivery routes, and sustainable sourcing.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mb-5">
                        <div class="col-12">
                            <h2 class="text-center mb-4">Meet Our Team</h2>
                            <div class="row">
                                <div class="col-lg-3 col-md-6 mb-4">
                                    <div class="team-member">
                                        <img src="https://randomuser.me/api/portraits/women/32.jpg" alt="Sarah Chen" class="team-img">
                                        <h5>Sarah Chen</h5>
                                        <p class="text-muted">Founder & CEO</p>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 mb-4">
                                    <div class="team-member">
                                        <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Michael Rodriguez" class="team-img">
                                        <h5>Michael Rodriguez</h5>
                                        <p class="text-muted">Operations Director</p>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 mb-4">
                                    <div class="team-member">
                                        <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Priya Sharma" class="team-img">
                                        <h5>Priya Sharma</h5>
                                        <p class="text-muted">Product Specialist</p>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 mb-4">
                                    <div class="team-member">
                                        <img src="https://randomuser.me/api/portraits/men/22.jpg" alt="David Kim" class="team-img">
                                        <h5>David Kim</h5>
                                        <p class="text-muted">Customer Experience</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-12 text-center">
                            <h2 class="mb-4">Get in Touch</h2>
                            <p class="mb-4">Have questions or want to learn more about FrozenFoodPanda? We'd love to hear from you!</p>
                            <a href="{{ route('contact.index') }}" class="btn btn-primary btn-lg">
                                <i class="fas fa-envelope me-2"></i>Contact Us
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .feature-card {
        padding: 25px;
        border-radius: var(--border-radius-lg);
        background-color: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.3);
        transition: all 0.3s ease;
        text-align: center;
    }
    
    .feature-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }
    
    .feature-icon {
        width: 70px;
        height: 70px;
        background-color: rgba(0, 136, 204, 0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        font-size: 24px;
        color: var(--primary-color);
    }
    
    .team-member {
        text-align: center;
        padding: 20px;
        transition: all 0.3s ease;
    }
    
    .team-img {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        object-fit: cover;
        margin-bottom: 15px;
        border: 5px solid rgba(255, 255, 255, 0.8);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }
    
    .team-member h5 {
        margin-bottom: 5px;
    }
    
    .team-member:hover {
        transform: translateY(-5px);
    }
</style>
@endsection