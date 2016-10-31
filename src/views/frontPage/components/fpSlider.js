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

    $('body').on('click', '.pause-btn', () => {
      clearInterval(interval);
    });

    $('body').on('click', '.play-btn', () => {
      self.startInterval();
    });

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



//
//
// let proto = {
//   initialize: function() {
//     let self = this;
//
//     if ( container ) {
//       self.setIndex(0);
//       self.indexListener();
//       self.startInterval();
//       self.addStopListener();
//       self.addNextListener();
//     } else {
//       return;
//     }
//   },
//
//   decreaseIndex: function(i) {
//     index = i;
//     $(container).trigger('updateBackwards');
//   },
//
//   setIndex: function(i) {
//     index = i;
//     $(container).trigger('updateBanner');
//   },
//
//   getIndex: function() {
//     let newIndex = index;
//     return newIndex;
//   },
//
//   indexListener: function() {
//     let self = this;
//
//     $(container).on('updateBanner', () => {
//       let maxLength = elements.length;
//
//       let ind = self.getIndex(),
//           prevIndex;
//
//       if ( ind === 0 ) {
//         prevIndex = maxLength - 1;
//       } else {
//         prevIndex = ind - 1;
//       }
//
//       let prevElement = $(container).find('.element-' + prevIndex),
//           newElement = $(container).find('.element-' + ind );
//
//       self.unhide(newElement);
//
//       setTimeout(() => {
//           self.animateOut(prevElement);
//           self.animateIn(newElement);
//
//           setTimeout(() => {
//               self.hide(prevElement);
//           }, 450);
//
//       }, 450);
//     });
//
//     $(container).on('updateBackwards', () => {
//       let maxLength = elements.length;
//
//       let ind = self.getIndex(),
//           nextIndex;
//
//       if ( ind === 0 ) {
//         nextIndex = maxLength - 1;
//       } else {
//         nextIndex = ind - 1;
//       }
//
//       let prevElement = $(container).find('.element-' + ind),
//           newElement = $(container).find('.element-' + nextIndex );
//
//       self.unhide(newElement);
//
//       setTimeout(() => {
//           self.animateOutBW(prevElement);
//           self.animateInBW(newElement);
//
//           setTimeout(() => {
//               self.hide(prevElement);
//           }, 450);
//
//       }, 450);
//     });
//   },
//
//   startInterval: function() {
//     let self = this;
//
//     interval = setInterval(() => {
//       let index = self.getIndex();
//       let newIndex = index + 1;
//
//       if ( newIndex === elements.length ) {
//         newIndex = 0;
//       }
//
//       self.setIndex(newIndex);
//     }, 5000);
//   },
//
//   addStopListener: function() {
//
//   },
//
//   addNextListener: function() {
//     let self = this;
//
//     $('body').on('click', '.next-btn', () => {
//       clearInterval(interval);
//       let currentIndex = self.getIndex(),
//           nextIndex;
//
//         if ( currentIndex === elements.length - 1 ) {
//           nextIndex = 0;
//         } else {
//           nextIndex = currentIndex + 1;
//         }
//
//       self.setIndex(nextIndex);
//     });
//
//     $('body').on('click', '.prev-btn', () => {
//       clearInterval(interval);
//       let currentIndex = self.getIndex(),
//           prevIndex;
//
//         if ( currentIndex === 0 ) {
//           prevIndex = elements.length - 1;
//         } else {
//           prevIndex = currentIndex - 1;
//         }
//
//       self.decreaseIndex(prevIndex);
//     });
//   },
//
//   animateIn: function(element) {
//     $(element).removeClass('pre-in');
//     $(element).addClass('active');
//   },
//
//   animateOut: function(element) {
//     $(element).removeClass('active');
//     $(element).addClass('out');
//   },
//
//   animateInBW: function(element) {
//     $(element).removeClass('pre-in-bw');
//     $(element).addClass('active');
//   },
//
//   animateOutBW: function(element) {
//     $(element).removeClass('active');
//     $(element).addClass('out-bw');
//   },
//
//   hide: function(element) {
//     $(element).removeClass('out');
//     $(element).addClass('hidden');
//   },
//
//   unhide: function(element) {
//     $(element).addClass('pre-in');
//     $(element).removeClass('hidden');
//   }
// }
