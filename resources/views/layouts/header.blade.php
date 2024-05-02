<div class="flex">
    <a href="{{ route('post.index') }}" class="dropdown-link {{ request()->routeIs('post.index') ? 'active' : '' }}">
        <h2 class="font-semibold text-center text-xl leading-tight {{ request()->routeIs('post.index') ? 'text-blue-600' : 'text-gray-500' }}">
            Home
        </h2>
    </a>
    <a href="{{ route('ranking.daily') }}" class="dropdown-link {{ request()->routeIs('ranking.daily') || request()->routeIs('ranking.weekly') || request()->routeIs('ranking.all') || request()->routeIs('ranking.monthly') ? 'active' : '' }}">
        <h2 class="font-semibold text-center text-xl leading-tight {{ request()->routeIs('ranking.daily') || request()->routeIs('ranking.weekly') || request()->routeIs('ranking.all') || request()->routeIs('ranking.monthly') ? 'text-blue-600' : 'text-gray-500' }}">
            Ranking
        </h2>
    </a>
    <a href="{{ route('post.new_post') }}" class="dropdown-link {{ request()->routeIs('post.new_post') ? 'active' : '' }}">
        <h2 class="font-semibold text-center text-xl leading-tight {{ request()->routeIs('post.new_post') ? 'text-blue-600' : 'text-gray-500' }}">
            Newest
        </h2>
    </a>
    <a href="{{ route('filter') }}" class="dropdown-link {{ request()->routeIs('filter') ? 'active' : '' }}">
        <h2 class="font-semibold text-center text-xl leading-tight {{ request()->routeIs('filter') ? 'text-blue-600' : 'text-gray-500' }}">
            Search
        </h2>
    </a>
    <x-validation-errors class="mb-4" :errors="$errors" />
</div>
<style>
    .dropdown-link {
        display: block;
        width: 100%;
        padding: 0.25rem 0.5rem;
        text-align: start;
        font-size: 0.875rem;
        line-height: 1.25rem;
        color: #4299e1;
        transition: background-color 0.15s ease-in-out, color 0.15s ease-in-out;
    }

    .dropdown-link:hover,
    .dropdown-link:focus {
        background-color: #f7fafc;
        outline: none;
    }

    .dropdown-link.active {
        background-color: transparent;
        color: #4299e1;
    }

    @media (min-width: 640px) {
        .dropdown-link {
            padding: 0.25rem 0.5rem;
        }
    }
</style>