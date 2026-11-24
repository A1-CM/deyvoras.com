@extends('layouts.marketing')

@section('title', 'Contract work, in clearer view')

@section('content')
<section class="home-hero" id="top">
    <div class="container home-hero-grid">
        <div class="home-hero-copy">
            <p class="hero-kicker"><span class="kicker-line"></span> A CLEARER WAY TO MANAGE AGREEMENTS</p>
            <h1>Good agreements<br>deserve <span>a better<br>everyday.</span></h1>
            <p class="home-hero-lede">Deyvoras gives your team one considered place for contracts, human review, and the commitments that keep business moving.</p>
            <div class="hero-actions"><a class="button" href="{{ route('register') }}">Create your workspace <span aria-hidden="true">→</span></a><a class="text-link" href="#features">Take a closer look <span aria-hidden="true">↓</span></a></div>
            <div class="hero-footnote"><span class="footnote-number">01</span><span>Private by organization.<br>Reviewed by your people.</span></div>
        </div>
        <div class="hero-art" aria-label="Illustration of organized agreements and review notes">
            <div class="art-grid"></div><div class="art-orbit art-orbit-large"></div><div class="art-orbit art-orbit-small"></div>
            <div class="art-stamp">THE<br>AGREEMENT<br>DESK</div>
            <div class="paper-stack"><div class="paper-sheet paper-back"><span class="paper-cap">SERVICE AGREEMENT</span><i></i><i></i><i class="short-line"></i><b>04.02</b></div><div class="paper-sheet paper-front"><span class="paper-cap">REVIEW NOTE  /  014</span><strong>Renewal terms</strong><i></i><i></i><i></i><span class="paper-check">✓ VERIFIED BY YOUR TEAM</span></div></div>
            <div class="art-side-label">FILES · TERMS · FOLLOW-THROUGH</div><span class="art-index">D—01</span>
        </div>
    </div>
    <div class="container hero-ribbon"><span>AGREEMENT WORK, CONNECTED</span><div><b>01</b> ORGANIZE <i>—</i> <b>02</b> REVIEW <i>—</i> <b>03</b> FOLLOW THROUGH</div><span>BUILT FOR TEAMS THAT CARE ABOUT THE DETAILS</span></div>
</section>

<section class="section home-about" id="about">
    <div class="container about-grid">
        <div class="about-visual">
            <div class="visual-corner visual-corner-top">FIELD NOTES <span>01 / 04</span></div>
            <div class="about-visual-lines"><span></span><span></span><span></span><span></span><span></span></div>
            <div class="about-quote-mark">“</div><p class="about-visual-caption">LESS HUNTING.<br>MORE KNOWING.</p>
            <div class="visual-corner visual-corner-bottom"><span>THE DEYVORAS APPROACH</span><span>EST. 2024</span></div>
        </div>
        <div class="about-copy"><p class="eyebrow">ABOUT DEYVORAS</p><h2>Make the important details easier to <em>carry forward.</em></h2><p>Agreements are part of everyday work, but their details often end up scattered across files, inboxes, and spreadsheets. Deyvoras is being built to give those details a clear home and the people responsible for them a practical way to stay connected.</p><p>We believe useful contract work should stay understandable: the original document nearby, recorded information visible, and review decisions made by people.</p><a class="text-link" href="#approach">The way we work <span aria-hidden="true">→</span></a></div>
    </div>
</section>

<section class="section feature-section" id="features">
    <div class="container section-heading-row"><div><p class="eyebrow">THE WORK, ALL IN ONE VIEW</p><h2>Less scattered.<br><em>More in step.</em></h2></div><p>Deyvoras connects the practical parts of agreement work, from the source file to the next person who needs to act.</p></div>
    <div class="container feature-mosaic">
        <article class="mosaic-card mosaic-main"><span class="feature-index">01 <i>—</i> REPOSITORY</span><div class="mosaic-art archive-art"><span class="archive-ring"></span><span class="archive-ring"></span><span class="archive-doc">D</span><span class="archive-note">SEARCH<br>BY DETAIL</span></div><h3>A home for every agreement.</h3><p>Keep signed files and useful details together. Find records by title, counterparty, category, or reference.</p><a class="mosaic-link" href="{{ route('register') }}" aria-label="Create a workspace for the agreement repository">Explore the repository <span>→</span></a></article>
        <article class="mosaic-card mosaic-review"><span class="feature-index">02 <i>—</i> REVIEW</span><div class="review-art"><span class="review-pin">✓</span><span class="review-rule"></span><span class="review-rule"></span><span class="review-rule short"></span><span class="review-highlight">REVIEWED</span></div><h3>Human review, made visible.</h3><p>Keep clause notes close to their source and make the review state clear to the whole team.</p></article>
        <article class="mosaic-card mosaic-dates"><span class="feature-index">03 <i>—</i> FOLLOW-THROUGH</span><div class="date-art"><div><small>NEXT MILESTONE</small><strong>18</strong><span>NOV · RENEWAL NOTICE</span></div><i>01 / 03</i></div><h3>Commitments with an owner.</h3><p>Assign follow-ups, add due dates, and see what is open before it slips off the list.</p></article>
    </div>
</section>

<section class="section workflow-section" id="workflow">
    <div class="container workflow-heading"><div><p class="eyebrow">A PRACTICAL RHYTHM</p><h2>From first file<br>to next step.</h2></div><p>Keep agreement work close to the people doing it. One calm process gives your team a shared sense of what is known and what comes next.</p></div>
    <div class="container workflow-steps">
        <article><span class="step-number">01</span><div class="step-line"></div><h3>Bring it together</h3><p>Upload an agreement, capture the basic details, and keep the private source file nearby.</p><small>STORE · CATEGORIZE · FIND</small></article>
        <article><span class="step-number">02</span><div class="step-line"></div><h3>Review what matters</h3><p>Record clauses and summaries. A teammate checks each detail against the executed agreement.</p><small>READ · RECORD · VERIFY</small></article>
        <article><span class="step-number">03</span><div class="step-line"></div><h3>Keep work moving</h3><p>Assign responsibilities, track due dates, and bring upcoming changes into view.</p><small>ASSIGN · MONITOR · ACT</small></article>
    </div>
</section>

<section class="section approach-section" id="approach">
    <div class="container approach-grid"><div class="approach-copy"><p class="eyebrow">A HUMAN-CENTERED FOUNDATION</p><h2>Good tools support judgment. They don’t replace it.</h2><p>Contract details deserve context. Deyvoras keeps recorded information alongside the original agreement and makes review activity visible, so your team can make decisions with the right source in reach.</p><ul class="approach-list"><li><span>01</span> Your organization’s records stay in its workspace</li><li><span>02</span> Source files remain private to signed-in teammates</li><li><span>03</span> Verification means a person checked the detail</li><li><span>04</span> Activity history helps teams keep context</li></ul><p class="approach-note">Deyvoras does not currently extract terms automatically or provide legal advice. Check important details against the source agreement.</p></div>
        <div class="approach-visual"><div class="approach-visual-head"><span>REVIEW PRINCIPLES</span><span>04 / 04</span></div><div class="approach-orbit"><div class="orbit-label orbit-source">SOURCE</div><div class="orbit-label orbit-team">YOUR TEAM</div><div class="orbit-label orbit-record">RECORD</div><div class="orbit-core"><span>D</span><small>STAY<br>CONNECTED</small></div></div><div class="approach-visual-foot"><span>TRACEABLE BY DESIGN</span><span>HUMAN-REVIEWED</span></div></div></div>
</section>

<section class="testimonial-section" id="stories">
    <div class="container testimonial-heading"><div><p class="eyebrow">THE VALUE OF A SHARED VIEW</p><h2>Room for better<br><em>working days.</em></h2></div><p class="testimonial-disclosure">Illustrative perspectives, not customer endorsements. We’ll replace these with verified customer stories as they become available.</p></div>
    <div class="container testimonial-carousel" data-testimonial-carousel aria-label="Illustrative team perspectives">
        <div class="testimonial-viewport"><div class="testimonial-track" data-testimonial-track>
            <article class="testimonial-card testimonial-featured" role="group" aria-roledescription="slide" aria-label="Perspective 1 of 3"><span class="quote-mark">“</span><blockquote>When the source, the reviewer, and the next date are visible together, it’s easier to move the work along with confidence.</blockquote><div class="quote-attribution"><span class="quote-avatar">L</span><span><b>Legal operations</b><small>Illustrative team perspective</small></span></div><span class="testimonial-index">PERSPECTIVE / 01</span></article>
            <article class="testimonial-card" role="group" aria-roledescription="slide" aria-label="Perspective 2 of 3"><span class="quote-mark">“</span><blockquote>We need a simple way to see who owns a commitment and what needs attention this month.</blockquote><div class="quote-attribution"><span class="quote-avatar quote-avatar-alt">O</span><span><b>Business operations</b><small>Illustrative team perspective</small></span></div><span class="testimonial-index">PERSPECTIVE / 02</span></article>
            <article class="testimonial-card" role="group" aria-roledescription="slide" aria-label="Perspective 3 of 3"><span class="quote-mark">“</span><blockquote>The signed agreement should stay close to every note we make about it.</blockquote><div class="quote-attribution"><span class="quote-avatar quote-avatar-alt">P</span><span><b>Procurement</b><small>Illustrative team perspective</small></span></div><span class="testimonial-index">PERSPECTIVE / 03</span></article>
        </div></div>
        <div class="testimonial-controls"><button class="testimonial-arrow" type="button" data-testimonial-prev aria-label="Previous perspective">←</button><span data-testimonial-status aria-live="polite">Perspective 1 of 3</span><button class="testimonial-arrow" type="button" data-testimonial-next aria-label="Next perspective">→</button><div class="testimonial-dots" role="group" aria-label="Choose a perspective"><button type="button" data-testimonial-dot="0" aria-label="Show perspective 1" aria-current="true"></button><button type="button" data-testimonial-dot="1" aria-label="Show perspective 2" aria-current="false"></button><button type="button" data-testimonial-dot="2" aria-label="Show perspective 3" aria-current="false"></button></div></div>
    </div>
</section>

<section class="section pricing-section" id="plans">
    <div class="container pricing-heading"><div><p class="eyebrow">SIMPLE START, CLEAR NEXT STEPS</p><h2>Plans shaped around<br><em>the way teams grow.</em></h2></div><p>Choose a workspace plan. Switch billing cadence to see monthly or annual pricing.</p></div>
    <div class="container billing-switch-wrap"><fieldset class="billing-switch" data-billing-switch><legend class="visually-hidden">Billing frequency</legend><button type="button" data-billing-period="monthly" aria-pressed="true">Monthly</button><button type="button" data-billing-period="yearly" aria-pressed="false">Yearly <span>Save 2 months</span></button></fieldset><small>USD · Per workspace</small></div>
    <div class="container pricing-grid">
        <article class="price-card" data-plan-card><div class="price-card-top"><span class="price-label">A SIMPLE START</span><span class="price-stamp">AVAILABLE</span></div><h3>Essentials</h3><p class="price-desc">A clear place to bring your agreements together.</p><p class="price-amount"><strong data-price-value data-monthly="$0" data-yearly="$0">$0</strong><span data-price-period data-monthly="/ month" data-yearly="/ year"> / month</span></p><span class="price-detail" data-price-detail data-monthly="Free to use" data-yearly="Free to use">Free to use</span><ul><li>Private organization workspace</li><li>Contract repository and file history</li><li>Human-reviewed clause records</li><li>Obligation tracking and reports</li></ul><a class="button button-outline button-full" href="{{ route('register') }}">Create a free workspace <span>→</span></a></article>
        <article class="price-card price-card-dark" data-plan-card><div class="price-card-top"><span class="price-label">FOR COLLABORATIVE TEAMS</span><span class="price-stamp">PROPOSED PLAN</span></div><h3>Team</h3><p class="price-desc">Shared agreement work with clear roles and follow-through.</p><p class="price-amount"><strong data-price-value data-monthly="$29" data-yearly="$290">$29</strong><span data-price-period data-monthly="/ month" data-yearly="/ year"> / month</span></p><span class="price-detail" data-price-detail data-monthly="Billed monthly" data-yearly="Billed annually · save $58">Billed monthly</span><ul><li>Everything in Essentials</li><li>Team invites and role-based access</li><li>Contract comparison and activity history</li><li>Reports for reviews and obligations</li></ul><a class="button button-inverse button-full" data-checkout-plan="team" href="{{ route('checkout.show', ['plan' => 'team', 'billing' => 'monthly']) }}">Continue to sandbox checkout <span>→</span></a></article>
        <article class="price-card" data-plan-card><div class="price-card-top"><span class="price-label">FOR ESTABLISHED WORKFLOWS</span><span class="price-stamp">PROPOSED PLAN</span></div><h3>Business</h3><p class="price-desc">A guided rollout for organizations with broader needs.</p><p class="price-amount"><strong data-price-value data-monthly="$99" data-yearly="$990">$99</strong><span data-price-period data-monthly="/ month" data-yearly="/ year"> / month</span></p><span class="price-detail" data-price-detail data-monthly="Billed monthly" data-yearly="Billed annually · save $198">Billed monthly</span><ul><li>Everything in Team</li><li>Guided workspace setup</li><li>Priority support contact</li><li>Roadmap planning conversation</li></ul><a class="button button-outline button-full" data-checkout-plan="business" href="{{ route('checkout.show', ['plan' => 'business', 'billing' => 'monthly']) }}">Continue to sandbox checkout <span>→</span></a></article>
    </div><p class="container pricing-footnote">Essentials is available today. Team and Business prices are proposed per-workspace rates; paid billing, plan limits, and Business services are not yet enabled.</p>
</section>

<section class="faq-section" id="faq">
    <div class="container faq-grid"><div class="faq-intro"><p class="eyebrow">GOOD QUESTIONS</p><h2>Clear answers,<br><em>before you begin.</em></h2><p>Want to know whether Deyvoras fits your current process? Start here, then get in touch if you have a more specific question.</p><a class="text-link" href="tel:+94210170264">Speak with our team <span>→</span></a></div>
        <div class="faq-list">
            <details><summary>What is Deyvoras for?<span>＋</span></summary><p>Deyvoras is a shared workspace for organizing agreements, recording important terms, tracking review work, and following up on obligations.</p></details>
            <details><summary>Does Deyvoras automatically read or interpret contracts?<span>＋</span></summary><p>No. The current application does not extract contract terms or make legal judgments. Your team enters information and checks it against the source document.</p></details>
            <details><summary>Who can see our agreements?<span>＋</span></summary><p>Records are scoped to your organization. Source documents are stored privately and are available to signed-in members of that workspace.</p></details>
            <details><summary>Can we invite colleagues with different access?<span>＋</span></summary><p>Yes. Owners can invite teammates and assign workspace roles. Legal reviewers and contract managers can manage contract records; members can view them.</p></details>
            <details><summary>Is there a free plan?<span>＋</span></summary><p>The current Essentials workspace is available at no cost, with no payment details required. The Team plan is a planned offering and is not currently sold.</p></details>
            <details><summary>Does Deyvoras provide legal advice?<span>＋</span></summary><p>No. Deyvoras helps organize working information. It does not provide legal advice or determine whether an agreement is valid or enforceable.</p></details>
        </div>
    </div>
</section>

<section class="closing-section"><div class="container closing-inner"><p class="eyebrow">START WITH A CLEARER VIEW</p><h2>Bring your agreements<br>back into <em>the picture.</em></h2><p>Create a private workspace and give the details a place to stay connected.</p><a class="button button-inverse" href="{{ route('register') }}">Create your workspace <span aria-hidden="true">→</span></a><span class="closing-note">NO PAYMENT DETAILS REQUIRED TO GET STARTED</span></div></section>
@endsection
