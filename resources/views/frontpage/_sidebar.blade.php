<ul>
    <li class="sidebar-header" style="display: block; padding: 0.3em 1em; color: white;">Spotlight of the Moment</li>
    <li class="sidebar-section text-center accordion" id="featAccordion">
        @foreach ($featuredChars as $character)
            <div class="sidebar-section-header" id="headingSpecies_{{ $character->image->species->id }}">
                <a class="btn btn-link @if ($character->image->species->id != $featuredFirst) collapsed @endif collapse-toggle" data-toggle="collapse" data-target="#collapseSpecies_{{ $character->image->species->id }}" aria-expanded="true"
                    aria-controls="collapseSpecies_{{ $character->image->species->id }}" style="margin-right:10px;">
                    <h4>{{ $character->image->species->name }}</h4>
                </a>
            </div>
            <div id="collapseSpecies_{{ $character->image->species->id }}" class="collapse @if ($character->image->species->id == $featuredFirst) show @endif" aria-labelledby="headingSpecies_{{ $character->image->species->id }}" data-parent="#featAccordion">
                <div>
                    <a href="{{ $character->url }}"><img src="{{ $character->image->thumbnailUrl }}" class="img-thumbnail" alt="Thumbnail for {{ $character->fullName }}" /></a>
                </div>
                <div class="mt-1">
                    <a href="{{ $character->url }}" class="h6 mb-0">
                        @if (!$character->is_visible)
                            <i class="fas fa-eye-slash"></i>
                        @endif {{ $character->fullName }}
                    </a>
                </div>
                <div class="small row">
                    <div class="col-6">{!! $character->image->rarity_id ? $character->image->rarity->displayName : 'No Rarity' !!}</div>
                    <div class="col-6">{!! $character->displayOwner !!}</div>
                </div>
                <div class="mb-1">
                    <button class="btn btn-sm {{ $character->is_gift_art_allowed == 1 ? 'badge-success' : ($character->is_gift_art_allowed == 2 ? 'badge-warning text-light' : 'badge-danger') }}" data-toggle="tooltip"
                        title="{{ $character->is_gift_art_allowed == 1 ? 'OPEN for gift art.' : ($character->is_gift_art_allowed == 2 ? 'PLEASE ASK before gift art.' : 'CLOSED for gift art.') }}"><i class="fas fa-pencil-ruler"></i></button>
                    <button class="btn btn-sm {{ $character->is_gift_writing_allowed == 1 ? 'badge-success' : ($character->is_gift_writing_allowed == 2 ? 'badge-warning text-light' : 'badge-danger') }}" data-toggle="tooltip"
                        title="{{ $character->is_gift_writing_allowed == 1 ? 'OPEN for gift writing.' : ($character->is_gift_writing_allowed == 2 ? 'PLEASE ASK before gift writing.' : 'CLOSED for gift writing.') }}">
                        <i class="fas fa-file-alt"></i>
                    </button>
                </div>
            </div>
            <hr style="margin: .5rem 1.5rem;" />
        @endforeach
    <p class="small">Spotlight changes every time you refresh this page.<br />Characters allow either gift art or gift writing.</p>
    </li>
</ul>
