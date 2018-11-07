// Cookie that stores the session ID
// Will be set as request.sessionID in `authenticate` and `friends` functions
exports.cookie = 'sessionid';

exports.authenticate = function(request, callback) {
    // Verify user based on request.
    // On failure, redirect user to auth form

    callback({
        username: 'username' + (Math.floor(Math.random() * 99) + 1),
        displayname: 'John Smith',
        otherinfo: 'any other relevant key/values'
    });
};

exports.friends = function(request, data, callback) {
    // Create a friends list based on given user data
    var users = [];
    for (var u=1; u <= 99; ++u) {
       users.push('username'+u);
    }

    callback(users);
};

