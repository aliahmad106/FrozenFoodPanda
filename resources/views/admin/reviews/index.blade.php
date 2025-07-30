@extends('layouts.app')

@section('title', 'Review Management')

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="mb-0"><i class="fas fa-star me-2 text-warning"></i>Review Management</h2>
                <div class="d-flex align-items-center">
                    <span class="badge bg-warning rounded-pill me-2">{{ $pendingReviews->count() }} Pending</span>
                    <span class="badge bg-success rounded-pill">{{ $approvedReviews->count() }} Approved</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Reviews Section -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0">
                    <span class="badge bg-warning me-2">
                        <i class="fas fa-clock"></i>
                    </span>
                    Pending Reviews
                </h4>
                <span class="badge bg-warning rounded-pill">{{ $pendingReviews->count() }}</span>
            </div>
        </div>
        <div class="card-body p-0">
            @if($pendingReviews->isEmpty())
                <div class="text-center py-5">
                    <div class="mb-3">
                        <i class="fas fa-check-circle fa-3x text-muted"></i>
                    </div>
                    <p class="text-muted mb-0">No pending reviews to moderate.</p>
                </div>
            @else
                <div class="list-group list-group-flush">
                    @foreach($pendingReviews as $review)
                        <div class="list-group-item p-4">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <h5 class="mb-1">{{ $review->product->name }}</h5>
                                    <p class="text-muted mb-0 small">
                                        <i class="fas fa-user me-1"></i> {{ $review->user->name }} 
                                        <span class="mx-2">•</span>
                                        <i class="fas fa-calendar-alt me-1"></i> {{ $review->created_at->format('M d, Y H:i') }}
                                    </p>
                                </div>
                                <div class="stars">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star {{ $i <= $review->rating ? 'text-warning' : 'text-muted' }}"></i>
                                    @endfor
                                </div>
                            </div>
                            
                            <div class="review-content p-3 bg-light rounded mb-3">
                                <p class="mb-0">{{ $review->comment }}</p>
                            </div>

                            <form action="{{ route('admin.reviews.moderate', $review) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                
                                <div class="mb-3">
                                    <label for="moderation_notes" class="form-label">Moderation Notes (Optional)</label>
                                    <textarea name="moderation_notes" id="moderation_notes" class="form-control" rows="2" placeholder="Add notes about why this review was approved or rejected..."></textarea>
                                </div>

                                <div class="d-flex gap-2">
                                    <button type="submit" name="status" value="approved" class="btn btn-success">
                                        <i class="fas fa-check me-2"></i> Approve
                                    </button>
                                    <button type="submit" name="status" value="rejected" class="btn btn-danger">
                                        <i class="fas fa-times me-2"></i> Reject
                                    </button>
                                </div>
                            </form>
                        </div>
                    @endforeach
                </div>

                <div class="d-flex justify-content-center py-3">
                    {{ $pendingReviews->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Approved Reviews Section -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0">
                    <span class="badge bg-success me-2">
                        <i class="fas fa-check"></i>
                    </span>
                    Approved Reviews
                </h4>
                <span class="badge bg-success rounded-pill">{{ $approvedReviews->count() }}</span>
            </div>
        </div>
        <div class="card-body p-0">
            @if($approvedReviews->isEmpty())
                <div class="text-center py-5">
                    <div class="mb-3">
                        <i class="fas fa-star fa-3x text-muted"></i>
                    </div>
                    <p class="text-muted mb-0">No approved reviews yet.</p>
                </div>
            @else
                <div class="list-group list-group-flush">
                    @foreach($approvedReviews as $review)
                        <div class="list-group-item p-4">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <h5 class="mb-1">{{ $review->product->name }}</h5>
                                    <p class="text-muted mb-0 small">
                                        <i class="fas fa-user me-1"></i> {{ $review->user->name }} 
                                        <span class="mx-2">•</span>
                                        <i class="fas fa-calendar-alt me-1"></i> {{ $review->created_at->format('M d, Y H:i') }}
                                    </p>
                                </div>
                                <div class="stars">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star {{ $i <= $review->rating ? 'text-warning' : 'text-muted' }}"></i>
                                    @endfor
                                </div>
                            </div>
                            
                            <div class="review-content p-3 bg-light rounded">
                                <p class="mb-0">{{ $review->comment }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="d-flex justify-content-center py-3">
                    {{ $approvedReviews->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection