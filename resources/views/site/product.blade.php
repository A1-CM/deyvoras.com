@extends('layouts.marketing')

@section('title', 'The Deyvoras product roadmap')

@section('content')
<section class="product-hero">
    <div class="container product-hero-grid"><div><p class="eyebrow product-status"><span></span> PRODUCT STATUS · CURRENT RELEASE</p><h1>Agreement work,<br>with a clearer <em>next.</em></h1><p>Deyvoras brings the source, the review, and the follow-through into one team workspace. Here’s what’s available now, what we’re shaping next, and where NVIDIA SDKs may fit.</p><div class="product-hero-actions"><a class="button" href="{{ route('register') }}">Create a workspace <span>→</span></a><a class="text-link" href="#current">See current status <span>↓</span></a></div></div>
        <div class="product-hero-art"><div class="product-orbit product-orbit-one"></div><div class="product-orbit product-orbit-two"></div><div class="product-status-card"><span class="eyebrow">PRODUCT SNAPSHOT</span><div><b>01</b><span>AVAILABLE<br>IN WORKSPACE</span></div><div><b>02</b><span>IN PRODUCT<br>DIRECTION</span></div><div><b>03</b><span>SDK<br>EXPLORATION</span></div></div><span class="product-art-label">CURRENT → NEXT → EXPLORE</span></div></div>
</section>

<section class="product-current section" id="current"><div class="container product-section-heading"><p class="eyebrow">01 / CURRENT STATUS</p><div><h2>Useful agreement work is available <em>today.</em></h2><p>The current release is a human-led workspace. Your team enters and reviews the information; Deyvoras keeps the records and next steps connected.</p></div></div>
    <div class="container product-status-grid">
        <article><span>01</span><h3>Organize the repository</h3><p>Create a private organization workspace, categorize contracts, search key details, and retain source document versions.</p><small>AVAILABLE NOW</small></article>
        <article><span>02</span><h3>Review against the source</h3><p>Record clauses and summaries, mark details checked by a person, and see review activity alongside the contract.</p><small>AVAILABLE NOW</small></article>
        <article><span>03</span><h3>Keep ownership visible</h3><p>Assign obligations, track dates, compare records, and use workspace reports to see what needs follow-through.</p><small>AVAILABLE NOW</small></article>
        <article><span>04</span><h3>Work with clear roles</h3><p>Invite teammates into organization-scoped records with owner, reviewer, contract manager, and read-only access.</p><small>AVAILABLE NOW</small></article>
    </div>
    <p class="container product-caveat">The current release does not automatically extract terms or provide legal advice. Clause details and summaries are entered and checked by your team.</p>
</section>

<section class="product-next section"><div class="container product-next-grid"><div><p class="eyebrow">02 / WHAT’S NEXT</p><h2>More help with the work that <em>comes after.</em></h2><p>Our next product direction focuses on helping teams spot upcoming work sooner and move through review with less manual coordination.</p><a class="text-link" href="{{ route('contact') }}">Share what your team needs <span>→</span></a></div><div class="product-roadmap">
    <article><span class="roadmap-mark">A</span><div><small>PRODUCT DIRECTION</small><h3>Renewal and notice planning</h3><p>More structured visibility into notice windows, renewal preparation, and follow-up ownership.</p></div><span class="roadmap-status">PLANNED</span></article>
    <article><span class="roadmap-mark">B</span><div><small>PRODUCT DIRECTION</small><h3>Review handoffs</h3><p>Clearer reviewer assignment and shared progress across the people working on an agreement.</p></div><span class="roadmap-status">PLANNED</span></article>
    <article><span class="roadmap-mark">C</span><div><small>PRODUCT DIRECTION</small><h3>Reporting and exports</h3><p>More flexible views for teams preparing portfolio and operational updates.</p></div><span class="roadmap-status">PLANNED</span></article>
    <p class="roadmap-note">These are areas of product direction, not dated delivery commitments.</p>
</div></div></section>

<section class="product-nvidia section" id="nvidia"><div class="container nvidia-heading"><div><p class="eyebrow">03 / NVIDIA SDK EXPLORATION</p><h2>Where document intelligence <em>could go.</em></h2></div><p>We’re exploring how NVIDIA’s document and inference tooling could support future contract workflows. No NVIDIA SDK or model is currently integrated into Deyvoras.</p></div>
    <div class="container nvidia-grid">
        <article><span class="nvidia-index">01</span><div class="nvidia-mark">NR</div><h3>NeMo Retriever</h3><p>Potential future direction: retrieval across agreement collections to help a reviewer find relevant source passages.</p><small>EXPLORATION · NOT INTEGRATED</small></article>
        <article><span class="nvidia-index">02</span><div class="nvidia-mark">NIM</div><h3>NVIDIA NIM</h3><p>Potential future direction: a managed inference path for document assistance, subject to product and privacy requirements.</p><small>EXPLORATION · NOT INTEGRATED</small></article>
        <article><span class="nvidia-index">03</span><div class="nvidia-mark">NG</div><h3>NeMo Guardrails</h3><p>Potential future direction: controls around any assistant that may be introduced into sensitive agreement work.</p><small>EXPLORATION · NOT INTEGRATED</small></article>
        <article><span class="nvidia-index">04</span><div class="nvidia-mark">TR</div><h3>Triton Inference Server</h3><p>Potential future direction: serving and scaling inference workloads if future product needs justify it.</p><small>EXPLORATION · NOT INTEGRATED</small></article>
    </div>
    <div class="container nvidia-note"><span>OUR BAR</span><p>Any future AI capability must keep the source visible, preserve human review, and meet appropriate privacy and security requirements before it becomes part of the product.</p></div>
</section>

<section class="closing-section"><div class="container closing-inner"><p class="eyebrow">BUILT AROUND REAL TEAM WORK</p><h2>Bring your agreements<br>into <em>clear view.</em></h2><p>Start with the current workspace or tell us what you’d like to see next.</p><a class="button button-inverse" href="{{ route('register') }}">Create your workspace <span>→</span></a><a class="product-contact-link" href="{{ route('contact') }}">Contact the team</a></div></section>
@endsection
