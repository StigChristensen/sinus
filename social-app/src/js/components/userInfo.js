import React from 'react';
import ReactDOM from 'react-dom';

let userInfo = ()=> {

  let InfoContainer = React.createClass({

    getInitialState: ()=> {
      return {
        data: {},
        profilepic: 'https://www.sinus-store.dk/social-api/img/placeholder.png',
        spinnerShow: true
      }
    },

    componentDidMount: function() {
      $.getJSON(this.props.source, function(result) {
        this.setState({
          data: result.data,
          profilepic: result.data.profile_picture,
          spinnerShow: false
        });
      }.bind(this));
    },

    render: function() {
      return (
        <div className="info-content">
          <img src={this.state.profilepic} />
          <h4 className="username">{this.state.data.username}</h4>
          <p className="name">{this.state.data.full_name}</p>
        </div>
      );
    }
  });

  let url = 'https://www.sinus-store.dk/social-api/api/getuserinfo.php';

  ReactDOM.render(
    <InfoContainer source={url} />,
    document.getElementById('user-info')
  );
}

module.exports = userInfo;
