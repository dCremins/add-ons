#!/bin/bash

if [ "$TRAVIS_BRANCH" != "test" ]; then
    exit 0;
fi

export GIT_COMMITTER_EMAIL= "devincrem@gmail.com"
export GIT_COMMITTER_NAME= "Travis CI"

git checkout master || exit
git merge "$TRAVIS_COMMIT" || exit
git push "https://${DEPLOY_KEY}@$github.com/dCremins/add-ons.git" development:master
