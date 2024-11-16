@push('styles')
<style>
/* Card Styles */
.card {
  position: sticky;
  top: var(--card-offset); /* Dynamically calculated gap */
}

.card__inner {
  will-change: transform;
  background: white;
  border-radius: 14px;
  display: flex;
  overflow: hidden;
  box-shadow: 0 25px 50px -12px hsla(265.3, 20%, 10%, 35%);
  transform-origin: center top;
}

.cards {
  --card-gap: 30px; /* Gap between sticky cards */
  --card-offset: 30px; /* Dynamically set gap from the header */
  width: 100%;
  max-width: 900px;
  margin: 0 auto;
  display: grid;
  grid-template-rows: repeat(var(--cards-count), var(--card-height));
  gap: var(--card-gap); /* Apply gap between cards */
}

.card__image-container {
  display: flex;
  width: 40%;
  flex-shrink: 0;
}

.card__image {
  width: 100%;
  height: 100%;
  object-fit: cover;
  aspect-ratio: 1;
}

.card__content {
  padding: 40px 30px;
  display: flex;
  flex-direction: column;
}

.card__title {
  padding: 0;
  margin: 15px;
  font-size: 40px;
  font-weight: 600;
  color: #16263a;
}

.card__description {
  line-height: 1.4;
  font-size: 24px;
  color: #16263a;
}

.space {
  height: 20vh;
}

.space--small {
  height: 20vh;
}

@media (max-width: 600px) {
  .card{
    margin: 20px;
  }
  .card__inner {
    flex-direction: column;
  }

  .card__image-container {
    width: 100%;
  }

  .card__image {
    aspect-ratio: 16 / 9;
  }

  .card__title {
    font-size: 32px;
  }

  .card__description {
    font-size: 16px;
  }

  .card__content {
    padding: 20px 20px;
  }
}

</style>
@endpush

<!-- HTML Structure -->
<div class="space space--small"></div>
<div class="cards">
  <div class="card" data-index="0">
    <div class="card__inner">
      <div class="card__image-container">
        <img
          class="card__image"
           src="{{ asset('assets/landing/img/events(2).jpg') }}"
          alt=""
        />
      </div>
      <div class="card__content">
        <h1 class="card__title">Scholarship Awarding Ceremony</h1>
        <p class="card__description">
        The Scholarship Awarding Ceremony for the Business & Social English and Frontier Technology Skills courses was held at the open stage field of Barishal University. The event was organized jointly by the Barishal University IT Society and the United Nations Development Programme (UNDP).
        </p>
      </div>
    </div>
  </div>
  <div class="card" data-index="1">
    <div class="card__inner">
      <div class="card__image-container">
        <img
          class="card__image"
          src="{{ asset('assets/landing/img/events(3).jpg') }}"
          alt=""
        />
      </div>
      <div class="card__content">
        <h1 class="card__title">IT Fest 1.0</h1>
        <p class="card__description">
        The first-ever IT Fest 1.0 was held at Barishal University. The event was organized by the Barishal University IT Society. The event was a huge success with over 1000 participants from different universities and colleges.
        </p>
      </div>
    </div>
  </div>
  <div class="card" data-index="2">
    <div class="card__inner">
      <div class="card__image-container">
        <img
          class="card__image"
          src="{{ asset('assets/landing/img/events(1).JPG') }}"
          alt=""
        />
      </div>
      <div class="card__content">
        <h1 class="card__title">it fest Programming contest </h1>
        <p class="card__description">
        Programming contest was held at Barishal University. The event was organized by the Barishal University IT Society.
        </p>
      </div>
    </div>
  </div>
  
</div>
<div class="space"></div>


@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", () => {
    const header = document.querySelector(".navbar");
    const cardsContainer = document.querySelector(".cards");
    const stickyCards = document.querySelectorAll(".card");

    if (header && cardsContainer && stickyCards.length > 0) {
        // Dynamically calculate header height
        const headerHeight = header.offsetHeight;
        const cardGap = 25; // Space between cards

        // Set dynamic CSS variable for the top offset
        cardsContainer.style.setProperty('--card-gap', `${cardGap}px`);
        cardsContainer.style.setProperty('--card-offset', `${headerHeight}px`);

        stickyCards.forEach((card, index) => {
            card.style.top = `calc(${headerHeight}px + ${cardGap * index}px)`;
        });

        // Handle resizing to adjust for dynamic header height
        window.addEventListener("resize", () => {
            const updatedHeaderHeight = header.offsetHeight;
            cardsContainer.style.setProperty('--card-offset', `${updatedHeaderHeight}px`);
            stickyCards.forEach((card, index) => {
                card.style.top = `calc(${updatedHeaderHeight}px + ${cardGap * index}px)`;
            });
        });
    } else {
        console.warn("Header or cards not found. Check your HTML structure.");
    }
});
</script>
@endpush
