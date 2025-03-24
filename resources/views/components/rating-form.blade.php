@props(['rateableId', 'model', 'city' => '', 'subdomain' => null, 'averageRating', 'id'])
<script>
    const averageRating = @json($averageRating) || 0;
</script>


<form action="{{ route('ratings.store') }}" method="POST" id="ratingForm">
    @csrf
    <input type="hidden" name="rateable_id" value="{{ $rateableId }}">
    <input type="hidden" name="rateable_type" value="App\Models\{{$model}}">
    <input type="hidden" name="city" value="{{$city}}">
    <input type="hidden" name="subdomain" value="{{$subdomain}}">
    <input type="hidden" name="id" value="{{$id}}">
    <input type="hidden" name="rating" id="selectedRatingInput">
</form>
