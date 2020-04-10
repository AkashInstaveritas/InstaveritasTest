<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\API\ApiController;
use Illuminate\Http\Request;
use App\Http\Requests\CreateReviewRequest;
use App\Repositories\Eloquent\ReviewRepository;

class ReviewController extends ApiController
{
    private $reviewRepository;

    public function __construct(ReviewRepository $reviewRepository)
    {
        $this->reviewRepository = $reviewRepository;
    }

    public function store(CreateReviewRequest $request)
    {
        // Will return only validated data
        $validated = $request->validated();

        $this->reviewRepository->create($validated);

        return $this->respond([
            'status' => 'success',
            'status_code' => $this->getStatusCode(),
            'message' => 'Review for the product added.',
        ]);
    }
}
