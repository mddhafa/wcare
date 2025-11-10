{{-- -------------------- Saved Messages -------------------- --}}
@if($get == 'saved')
    <table class="messenger-list-item" data-contact="{{ Auth::user()->id }}">
        <tr data-action="0">
            {{-- Avatar side --}}
            <td>
            <div class="saved-messages avatar av-m">
                <span class="far fa-bookmark"></span>
            </div>
            </td>
            {{-- center side --}}
            <td>
                <p data-id="{{ Auth::user()->id }}" data-type="user">Saved Messages <span>You</span></p>
                <span>Save messages secretly</span>
            </td>
        </tr>
    </table>
@endif

{{-- -------------------- Contact list -------------------- --}}
{{-- -------------------- Contact list (Show All Users) -------------------- --}}
@if($get == 'users')
    @php
        $allUsers = \App\Models\User::where('user_id', '!=', auth()->id())->get();
    @endphp

    @foreach($allUsers as $user)
        <table class="messenger-list-item" data-contact="{{ $user->id }}">
            <tr data-action="0">
                {{-- Avatar --}}
                <td style="position: relative">
                    @if($user->active_status)
                        <span class="activeStatus"></span>
                    @endif
                    <div class="avatar av-m"
                        style="background-image: url('{{ $user->avatar }}');">
                    </div>
                </td>

                {{-- Info --}}
                <td>
                    <p data-id="{{ $user->id }}" data-type="user">
                        {{ strlen($user->name) > 12 ? trim(substr($user->name,0,12)).'..' : $user->name }}
                    </p>
                    <span>{{ $user->active_status ? 'Online' : 'Offline' }}</span>
                </td>
            </tr>
        </table>
    @endforeach
@endif


{{-- -------------------- Search Item -------------------- --}}
@if($get == 'search_item')
<table class="messenger-list-item" data-contact="{{ $user->id }}">
    <tr data-action="0">
        {{-- Avatar side --}}
        <td>
        <div class="avatar av-m"
        style="background-image: url('{{ $user->avatar }}');">
        </div>
        </td>
        {{-- center side --}}
        <td>
            <p data-id="{{ $user->id }}" data-type="user">
            {{ strlen($user->name) > 12 ? trim(substr($user->name,0,12)).'..' : $user->name }}
        </td>

    </tr>
</table>
@endif

{{-- -------------------- Shared photos Item -------------------- --}}
@if($get == 'sharedPhoto')
<div class="shared-photo chat-image" style="background-image: url('{{ $image }}')"></div>
@endif


