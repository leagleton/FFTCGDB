@if (isset($public_decks))
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 style="margin-top: 8px;">{{$public_deck_title or "Latest 10 Public Decks"}}</h3>
            @if (Auth::user()->admin && !empty($paginate))
                <h6 style="margin-top: 8px;">
                    Showing results 
                        {{ (($public_decks->currentPage()-1) * $public_decks->perPage()) + 1 }}
                        -
                        @if ($public_decks->perPage() == $public_decks->count())
                            {{ $public_decks->currentPage() * $public_decks->perPage() }}
                        @else
                            {{ $public_decks->total() }} 
                        @endif
                        of {{ $public_decks->total() }}
                </h6>
            @endif
        </div>
        <div class="panel-body">
            @if ($public_decks->count() > 0)

                @foreach ($public_decks as $deck)
                    <div class='deck-row-layout'>
                        <h4>
                            <a href="/d/{{ $deck->id }}">{{ $deck->name }}</a>
                            <span class='elements'>@foreach ($deck->elements() as $el) <img title="{{$el}}" alt="{{$el}}" height="12" width="12" src="/img/icons/{{$el}}.png"/> @endforeach</span>
                        </h4>
                        <h6>
                            Created by <a href="/u/{{ $deck->author() }}">{{ $deck->author() }}</a>
                            @if (!$deck->checkvalid()) 
                            | <span title="Invalid deck size - 50 cards exactly needed. {{ $deck->cardcount() }} in deck." alt="Invalid deck size - 50 cards exactly needed  {{ $deck->cardcount() }} in deck." class="label label-warning label-small">Invalid Deck Size</span>
                            @endif
                        </h6>
                        <p>@if (empty($deck->description)) << No Description >> @else {{ $deck->description }} @endif</p>
                    </div>
                @endforeach

            @else
                <p>No public decks yet!</p>
            @endif
        </div>
    </div>
    @if (!empty($paginate))
        {{ $public_decks->links() }}
    @endif;
@endif