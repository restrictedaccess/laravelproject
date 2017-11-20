# Pegara's Brain Salvation Project

## Front-end Development Repository

### Getting Started

#### Prerequisites

- Ruby: https://www.ruby-lang.org/en/downloads/

- Ruby Gems:
  - Update Gems itself: `gem update --system`
  - [SCSS](http://sass-lang.com/install): `gem install scss`
  - [Compass](http://compass-style.org/install/): `gem install compass`

- Node.js: https://nodejs.org/en/download/package-manager/

- Node Utilities:
  - [Bower](http://bower.io/#install-bower): `npm install -g bower`
  - [Grunt](http://gruntjs.com/getting-started#installing-the-cli): `npm install -g grunt-cli`

#### Setup Development Environment

- Clone the repository:

```
git clone https://github.com/AsianTechInc/pegara-brain-salvation.git
cd pegara-brain-salvation/front-end
```

- Then we should have following structure:

```
pegara-brain-salvation/
├── (back-end stuffs)
└── front-end
    ├── build/
    ├── dev/
    |   ├── html/
    |   ├── javascript/
    |   └── stylesheet/
    ├── bower.json
    ├── Gruntfile.js
    └── package.json
```

- Get pre-defined dependencies

```
npm install
```

- Build the whole project for the first time:

```
grunt dev
```

- Run the `localhost` at port `9003`

```
grunt server
```

Now, you can access the server follow this address: http://localhost:9003
