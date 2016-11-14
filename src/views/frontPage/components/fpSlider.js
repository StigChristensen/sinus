const $ = jQuery;

let nextIndex, prevIndex, currentIndex, maxLength, interval, container = $('body').find('.banners-container'), elements = $('body').find('.banner-element');

module.exports = {
  initialize: function() {
    let self = this;

    if ( container ) {
      maxLength = elements.length;
      self.setCurrentIndex(1);
      self.startInterval();
      self.eventListeners();
    } else {
      return;
    }
  },

  setCurrentIndex: function(index) {
    currentIndex = index;
  },

  setNextIndex: function(index) {
    nextIndex = index;
  },

  setPrevIndex: function(index) {
    prevIndex = index;
  },

  getCurrentIndex: function() {
    let ci = currentIndex;
    return ci;
  },

  getNextIndex: function() {
    let ni = nextIndex;
    return ni;
  },

  getPrevIndex: function() {
    let pi = nextIndex;
    return pi;
  },

  moveForward: function() {
    let self = this,
        ci = self.getCurrentIndex(),
        ni, pi;

        if ( ci === maxLength ) {
          ni = 1;
          self.setNextIndex(ni);
        } else {
          ni = ci + 1;
          self.setNextIndex(ni);
        }

    let nextElement = $('body').find('.element-' + ni),
        currentElement = $('body').find('.element-' + ci);

    self.unhide(nextElement);

    setTimeout(() => {
        self.animateOutFW(currentElement);
        self.animateInFW(nextElement);

        self.setCurrentIndex(ni);

        setTimeout(() => {
            self.hide(currentElement);
        }, 450);
    }, 450);
  },

  moveBackward: function() {
    let self = this,
        ci = self.getCurrentIndex(),
        ni, pi;

        if ( ci === 1 ) {
          ni = maxLength;
          self.setNextIndex(ni);
        } else {
          ni = ci - 1;
          self.setNextIndex(ni);
        }

    let nextElement = $('body').find('.element-' + ni),
        currentElement = $('body').find('.element-' + ci);

    self.unhideBW(nextElement);

    setTimeout(() => {
        self.animateOutBW(currentElement);
        self.animateInBW(nextElement);

        self.setCurrentIndex(ni);

        setTimeout(() => {
            self.hideBW(currentElement);
        }, 450);
    }, 450);
  },

  eventListeners: function() {
    let self = this;

    $('body').on('click', '.next-btn', () => {
      clearInterval(interval);
      self.moveForward();
    });

    $('body').on('click', '.prev-btn', () => {
      clearInterval(interval);
      self.moveBackward();
    });
  },

  startInterval: function() {
    let self = this;

    interval = setInterval(() => {
      self.moveForward();
    }, 5000);
  },

  animateInFW: function(element) {
    $(element).removeClass('pre-in');
    $(element).addClass('active');
  },

  animateOutFW: function(element) {
    $(element).removeClass('active');
    $(element).addClass('out');
  },

  animateInBW: function(element) {
    $(element).removeClass('pre-in-bw');
    $(element).addClass('active');
  },

  animateOutBW: function(element) {
    $(element).removeClass('active');
    $(element).addClass('out-bw');
  },

  hide: function(element) {
    $(element).removeClass('out');
    $(element).addClass('hidden');
  },

  unhide: function(element) {
    $(element).addClass('pre-in');
    $(element).removeClass('hidden');
  },

  hideBW: function(element) {
    $(element).removeClass('out-bw');
    $(element).addClass('hidden');
  },

  unhideBW: function(element) {
    $(element).addClass('pre-in-bw');
    $(element).removeClass('hidden');
  }
}
