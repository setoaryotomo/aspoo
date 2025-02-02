@extends("portal_layout.templates")
@section("content")
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .rating-title {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 30px;
            text-align: center;
        }
        .star-list {
            list-style: none;
            display: flex;
            justify-content: center;
        }
        .star-item {
            margin: 0 10px;
            cursor: pointer;
            transition: color 0.3s;
        }
        .star-item:hover,
        .star-item.active {
            color: #FF5733;
        }
        .star-item {
            display: inline-block;
            background-color: #F0F0F0;
            padding: 10px;
            margin: 10px;
            border-radius: 5px;
        }
        .review-container {
            margin-top: 20px;
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }
        .review-card {
            display: flex;
            align-items: center;
            margin-top: 10px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .review-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 10px;
        }

        .review-details {
            flex: 1;
        }

        .review-name {
            font-weight: 600;
        }

        .review-rating {
            color: #FF5733;
            font-weight: 600;
            margin-top: 5px;
        }

        .review-comment {
            margin-top: 5px;
            background-color: #F0F0F0;
            padding: 10px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="rating-title">Rating dan Ulasan</div>
        <ul class="star-list">
            <li class="star-item" data-rating="5">5 ★</li>
            <li class="star-item" data-rating="4">4 ★</li>
            <li class="star-item" data-rating="3">3 ★</li>
            <li class="star-item" data-rating="2">2 ★</li>
            <li class="star-item" data-rating="1">1 ★</li>
        </ul>

        <!-- Dummy Data -->
        <div id="review-container">
            <!-- Reviews will be dynamically added here based on selected rating -->
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const starItems = document.querySelectorAll('.star-item');
        const reviewContainer = document.getElementById('review-container');
        
        starItems.forEach(starItem => {
            starItem.addEventListener('click', () => {
                const rating = starItem.getAttribute('data-rating');
                showReviewsByRating(rating);
            });
        });

        function showReviewsByRating(rating) {
            reviewContainer.innerHTML = ''; // Clear previous reviews

            // Loop through dummyData to filter and display reviews by rating
            dummyData.forEach(data => {
                if (data.rating === parseInt(rating)) {
                    const reviewCard = createReviewCard(data);
                    reviewContainer.appendChild(reviewCard);
                }
            });
        }

        function createReviewCard(data) {
            const card = document.createElement('div');
            card.classList.add('review-card');

            const avatar = document.createElement('img');
            avatar.classList.add('review-avatar');
            avatar.src = '../img/portal/user.png';
            avatar.alt = 'Customer Avatar';
            card.appendChild(avatar);

            const content = document.createElement('div');
            content.classList.add('review-content');

            const name = document.createElement('div');
            name.classList.add('review-name');
            name.textContent = data.name;
            content.appendChild(name);

            const rating = document.createElement('div');
            rating.classList.add('review-rating');
            for (let i = 0; i < data.rating; i++) {
                const starIcon = document.createElement('i');
                starIcon.classList.add('fas', 'fa-star');
                rating.appendChild(starIcon);
            }
            content.appendChild(rating);

            const comment = document.createElement('div');
            comment.classList.add('review-comment');
            comment.textContent = data.comment;
            content.appendChild(comment);

            card.appendChild(content);
            return card;
        }

        const NUM_REVIEWS_PER_RATING = 4; // Jumlah ulasan per rating

        function generateDummyData() {
            const ratings = [1, 2, 3, 4, 5];
            const dummyData = [];

            for (const rating of ratings) {
                for (let i = 1; i <= NUM_REVIEWS_PER_RATING; i++) {
                    const review = {
                        avatar: `avatar${i}.jpg`,
                        name: `Customer ${i}`,
                        rating: rating,
                        comment: `Ulasan dari Customer ${i} dengan ${rating} bintang`
                    };
                    dummyData.push(review);
                }
            }

            return dummyData;
        }

        const dummyData = generateDummyData();

    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection