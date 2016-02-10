import React from 'react';
import ReactDOM from 'react-dom';

let userFeed = ()=> {

    function updateMenuHeight() {
      $(document).on('ready', function() {
        setTimeout(function() {
          let mainMenu = $('body').find('.main-menu'),
              footer = $('body').find('footer'),
              footerPosition = $(footer).position();

          // set menu height, relative to content height
          $(mainMenu).css({
            'height': footerPosition.top + 100 + 'px'
          });
        }, 2000);
      });
    }

  // React

  let FeedContainer = React.createClass({

    getInitialState: ()=> {
      return {
        data: []
      }
    },

    componentDidMount: function() {
      $.getJSON(this.props.source, function(result) {
        this.setState({
          data: result.data
        });
      }.bind(this));
    },

    render: function() {
      let content;

      if ( !this.state.data ) {
        content = <Spinner />;
      } else {
        content = <ImageFeed data={this.state.data} />;
        updateMenuHeight();
      }

      return (
        <div className="feed-content">
          {content}
        </div>
      );
    }
  });

  let ImageFeed = React.createClass({
    render: function() {
      return (
        <div className="image-nodes">
          { this.props.data.map((image) => {
              return (
                <Image key={image.id}
                  id={image.id}
                  thumb={image.images.standard_resolution.url}
                  likes={image.likes.count}
                  comments={image.comments.count}
                  link={image.link}
                ></Image>
              );
            }) }
        </div>
      );
    }
  });

  let Image = React.createClass({
    render: function() {
      return (
        <div className="image-container">
          <a href={this.props.link} target="_blank"><img className="feed-thumb" src={this.props.thumb} /></a>
          <div className="like-bar">
            <img className="like-icon" src="https://www.sinus-store.dk/social-api/img/like.png" /><p className="likes">{this.props.likes}</p>
            <img className="comments-icon" src="https://www.sinus-store.dk/social-api/img/comments.png" /><p className="comments">{this.props.comments}</p>
          </div>
        </div>
      );
    }
  });

  let Spinner = React.createClass({
    render: function() {
      return (
        <div className="spinner">
          <div className="circle"></div>
          <div className="circle1"></div>
        </div>
      );
    }
  })

  let url = 'https://www.sinus-store.dk/social-api/api/getuserfeed.php';

  ReactDOM.render(
    <FeedContainer source={url} />,
    document.getElementById('user-feed')
  );
}

module.exports = userFeed;


