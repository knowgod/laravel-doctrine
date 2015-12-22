@if ($tags)
    <div class="tag-cloud">
        <h4>Tags:</h4>
        <ul>
            @foreach($tags as $tag)
                <li>
                    <input id="tag_{{ $tag->getId() }}" type="checkbox" name="tag[]" value="{{ $tag->getId() }}"/>
                    <label for="tag_{{ $tag->getId() }}">{{ $tag->getName() }}</label>
                </li>
            @endforeach
        </ul>
    </div>
@endif