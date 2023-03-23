@foreach ($errors->all() as $message) {
    {{ $message }}
}
@endforeach
<div class="signup-content js-step js-step-one active">
    <div class="signup-progress-wrapper">
        <h2 class="signup-subtitle">Create a film club</h2>

        <div class="signup-progress">
            <ol class="signup-progress-list">
                <li class="signup-progress-item js-progress js-progress-one active">
                    <span class="signup-progress-item-number">1</span>
                </li>
                <li class="signup-progress-item js-progress js-progress-two no-events">
                    <span class="signup-progress-item-number">2</span>
                </li>
                <li class="signup-progress-item js-progress js-progress-three no-events">
                    <span class="signup-progress-item-number">3</span>
                </li>
            </ol>
        </div>
    </div>
    <form class="signup-form js-signup-one">
        <label for="club_name" class="signup-label">What would you like to name your club?</label>
        <div class="signup-input-wrapper">
            <input class="signup-input js-data-name" type="text" name="club_name" id="club_name" placeholder="Name your club" required>
        </div>
        <label for="members" class="signup-label">How many members would you like to include?</label>
        <div class="signup-input-wrapper">
            <select class="signup-select signup-input js-data-members" name="members" id="members" placeholder="Select amount" required>
                @for ($i=2; $i < 9; $i++)
                    <option class="signup-option" value="{{ $i }}">{{ $i }}</option>
                @endfor
            </select>
        </div>

        <p class="signup-text">Each user will get a turn to pick a film. Once every member has picked one, a round will be completed. Rounds will continue on a rolling basis.</p>

        <button data-step="1" class="js-validate-step signup-submit button">Save and proceed to pick a film</button>
    </form>
</div>
