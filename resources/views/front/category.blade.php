<div class="single-widget">
    <h3>All Categories</h3>
    <ul class="list">
        @foreach($groupedCategories as $categoryName => $categories)
        <li>
            <a href="{{ route('categ.show', $categories[0]->slug) }}">{{ $categoryName }}</a>
            <span>({{ count($categories) }})</span>
        </li>
        @endforeach
    </ul>
    <style>
        .list {
            max-height: 350px;
            overflow-y: auto;
            position: relative;
            color: #14d;
        }

    </style>
</div>
