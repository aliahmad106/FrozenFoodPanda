@extends('layouts.app')

@section('title', 'Contact Us')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h1 class="mb-0">Contact Us</h1>
                </div>
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-lg-5 mb-4 mb-lg-0">
                            <h4>Get in Touch</h4>
                            <p>Have questions, feedback, or need assistance? We're here to help! Fill out the form and our team will get back to you as soon as possible.</p>
                            
                            <div class="contact-info mt-4">
                                <div class="d-flex mb-3">
                                    <div class="contact-icon me-3">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-1">Our Location</h5>
                                        <p class="mb-0">123 Frozen Lane, Iceville</p>
                                    </div>
                                </div>
                                
                                <div class="d-flex mb-3">
                                    <div class="contact-icon me-3">
                                        <i class="fas fa-phone"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-1">Phone Number</h5>
                                        <p class="mb-0">(555) 123-4567</p>
                                    </div>
                                </div>
                                
                                <div class="d-flex mb-3">
                                    <div class="contact-icon me-3">
                                        <i class="fas fa-envelope"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-1">Email Address</h5>
                                        <p class="mb-0">frozenfoodpanda347@gmail.com</p>
                                    </div>
                                </div>
                                
                                <div class="d-flex mb-3">
                                    <div class="contact-icon me-3">
                                        <i class="fas fa-clock"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-1">Business Hours</h5>
                                        <p class="mb-0">Monday - Friday: 9 AM to 6 PM</p>
                                        <p class="mb-0">Saturday: 10 AM to 4 PM</p>
                                        <p class="mb-0">Sunday: Closed</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="social-links mt-4">
                                <h5>Connect With Us</h5>
                                <div class="d-flex mt-2">
                                    <a href="#" class="social-link me-2">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                    <a href="#" class="social-link me-2">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                    <a href="#" class="social-link me-2">
                                        <i class="fab fa-instagram"></i>
                                    </a>
                                    <a href="#" class="social-link">
                                        <i class="fab fa-pinterest"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-lg-7">
                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif
                            
                            @if(session('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif
                            
                            <form action="{{ route('contact.send') }}" method="POST" class="contact-form">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="name" class="form-label">Your Name</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="Enter your name" required>
                                        </div>
                                        @error('name')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="email" class="form-label">Email Address</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="Enter your email" required>
                                        </div>
                                        @error('email')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Phone Number (Optional)</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                        <input type="tel" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone') }}" placeholder="Enter your phone number">
                                    </div>
                                    @error('phone')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="subject" class="form-label">Subject</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-tag"></i></span>
                                        <select class="form-select @error('subject') is-invalid @enderror" id="subject" name="subject" required>
                                            <option value="" selected disabled>Select a subject</option>
                                            <option value="General Inquiry" {{ old('subject') == 'General Inquiry' ? 'selected' : '' }}>General Inquiry</option>
                                            <option value="Product Question" {{ old('subject') == 'Product Question' ? 'selected' : '' }}>Product Question</option>
                                            <option value="Order Issue" {{ old('subject') == 'Order Issue' ? 'selected' : '' }}>Order Issue</option>
                                            <option value="Delivery Problem" {{ old('subject') == 'Delivery Problem' ? 'selected' : '' }}>Delivery Problem</option>
                                            <option value="Feedback" {{ old('subject') == 'Feedback' ? 'selected' : '' }}>Feedback</option>
                                            <option value="Other" {{ old('subject') == 'Other' ? 'selected' : '' }}>Other</option>
                                        </select>
                                    </div>
                                    @error('subject')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="message" class="form-label">Message</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-comment"></i></span>
                                        <textarea class="form-control @error('message') is-invalid @enderror" id="message" name="message" rows="5" placeholder="Enter your message" required>{{ old('message') }}</textarea>
                                    </div>
                                    @error('message')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3 form-check">
                                    <input type="checkbox" class="form-check-input @error('privacy_policy') is-invalid @enderror" id="privacy_policy" name="privacy_policy" required {{ old('privacy_policy') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="privacy_policy">
                                        I agree to the <a href="{{ route('privacy') }}" target="_blank">Privacy Policy</a> and consent to the processing of my data.
                                    </label>
                                    @error('privacy_policy')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-paper-plane me-2"></i>Send Message
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card border-0 shadow-sm mt-4">
                <div class="card-body p-0">
                    <div class="location-image">
                        <img src="{{ asset('images/store-location.jpg') }}" alt="Store Location" class="img-fluid w-100 rounded" onerror="this.onerror=null; this.src='https://via.placeholder.com/1200x400/f8f9fa/0088cc?text=FrozenFoodPanda+Location';">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .contact-icon {
        width: 40px;
        height: 40px;
        background-color: rgba(0, 136, 204, 0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary-color);
    }
    
    .social-link {
        width: 40px;
        height: 40px;
        background-color: rgba(0, 136, 204, 0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary-color);
        transition: all 0.3s ease;
    }
    
    .social-link:hover {
        background-color: var(--primary-color);
        color: white;
        transform: translateY(-3px);
    }
    
    .location-image {
        border-radius: var(--border-radius-lg);
        overflow: hidden;
        height: 400px;
    }
    
    .location-image img {
        object-fit: cover;
        height: 100%;
        width: 100%;
    }
</style>
@endsection