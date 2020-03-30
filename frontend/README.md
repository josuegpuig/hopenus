## Installation Process

This is the frontend project made in Vue, it communicates with the backend via API, some key features are:

- Authenticate user with the Facebook SDK.
- Share the top news using [News API](https://newsapi.org/).
- Generates interaction by making posts and comments.
- Has a search page to quickly search in the posts

## Steps

- Make sure you have installed [Node](https://nodejs.org/)
- Run `npm install`

## Communication with the Frontend

In order to make work the project you need to communicate both projects.

- Run the server
```
npm run serve
```
- **As this project authenticates with Facebook SDK this will run with https configuration with a self-signed ssl, you need to click on proceed if a warning appears**
