


<div class="space space--small"></div>
<div class="cards">
  <div class="card" data-index="0">
    <div class="card__inner">
      <div class="card__image-container">
        <img
          class="card__image"
          src="https://images.unsplash.com/photo-1620207418302-439b387441b0?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1200&q=100"
          alt=""
        />
      </div>
      <div class="card__content">
        <h1 class="card__title">Card Title</h1>
        <p class="card__description">
          Lorem ipsum dolor sit amet consectetur adipisicing elit. Ab dicta
          error nam eaque. Eum fuga laborum quos expedita iste saepe
          similique, unde possimus quia at magnam sed cupiditate?
          Reprehenderit, harum!
        </p>
      </div>
    </div>
  </div>
  <div class="card" data-index="0">
    <div class="card__inner">
      <div class="card__image-container">
        <img
          class="card__image"
          src="https://images.unsplash.com/photo-1620207418302-439b387441b0?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1200&q=100"
          alt=""
        />
      </div>
      <div class="card__content">
        <h1 class="card__title">Card Title</h1>
        <p class="card__description">
          Lorem ipsum dolor sit amet consectetur adipisicing elit. Ab dicta
          error nam eaque. Eum fuga laborum quos expedita iste saepe
          similique, unde possimus quia at magnam sed cupiditate?
          Reprehenderit, harum!
        </p>
      </div>
    </div>
  </div>
  <div class="card" data-index="0">
    <div class="card__inner">
      <div class="card__image-container">
        <img
          class="card__image"
          src="https://images.unsplash.com/photo-1620207418302-439b387441b0?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1200&q=100"
          alt=""
        />
      </div>
      <div class="card__content">
        <h1 class="card__title">Card Title</h1>
        <p class="card__description">
          Lorem ipsum dolor sit amet consectetur adipisicing elit. Ab dicta
          error nam eaque. Eum fuga laborum quos expedita iste saepe
          similique, unde possimus quia at magnam sed cupiditate?
          Reprehenderit, harum!
        </p>
      </div>
    </div>
  </div>
</div>
<div class="space"></div>

@push('scripts')
<script>
    // This was built using aat.js: https://github.com/TahaSh/aat

const { ScrollObserver, valueAtPercentage } = aat

const cardsContainer = document.querySelector('.cards')
const cards = document.querySelectorAll('.card')
cardsContainer.style.setProperty('--cards-count', cards.length)
cardsContainer.style.setProperty(
  '--card-height',
  `${cards[0].clientHeight}px`
)
Array.from(cards).forEach((card, index) => {
  const offsetTop = 20 + index * 20
  card.style.paddingTop = `${offsetTop}px`
  if (index === cards.length - 1) {
    return
  }
  const toScale = 1 - (cards.length - 1 - index) * 0.1
  const nextCard = cards[index + 1]
  const cardInner = card.querySelector('.card__inner')
  ScrollObserver.Element(nextCard, {
    offsetTop,
    offsetBottom: window.innerHeight - card.clientHeight
  }).onScroll(({ percentageY }) => {
    cardInner.style.scale = valueAtPercentage({
      from: 1,
      to: toScale,
      percentage: percentageY
    })
    cardInner.style.filter = `brightness(${valueAtPercentage({
      from: 1,
      to: 0.6,
      percentage: percentageY
    })})`
  })
})
</script>

@endpush