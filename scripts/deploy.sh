#!/usr/bin/env ruby

# HOWTO:
# copy this file to script/travis-deploy
# chmod +x script/travis-deploy
# add the following to your .travis.yml
# after_success:
#  - "script/travis-deploy"


exit if ENV["TRAVIS_DEPLOY_PUSHED"]

# set defaults
ENV["TRAVIS_DEPLOY_SOURCE_BRANCH"] ||= "development"
ENV["TRAVIS_DEPLOY_TARGET_BRANCH"] ||= "master"

# make sure we only deploy the correct branch
if ENV["TRAVIS_BRANCH"] != ENV["TRAVIS_DEPLOY_SOURCE_BRANCH"] || ENV["TRAVIS_PULL_REQUEST"] != "false"
  puts "no deployment for:  #{ENV["TRAVIS_BRANCH"]} pull request: #{ENV["TRAVIS_PULL_REQUEST"]} job number: #{ENV["TRAVIS_JOB_NUMBER"]}"
  exit(true)
end

# push from the source branch to the master branch
puts "pushing from #{ENV["TRAVIS_DEPLOY_SOURCE_BRANCH"]} to #{ENV["TRAVIS_DEPLOY_TARGET_BRANCH"]}"
`git config user.name Choco`
`git checkout #{ENV["TRAVIS_DEPLOY_SOURCE_BRANCH"]}`
`git push origin #{ENV["TRAVIS_DEPLOY_SOURCE_BRANCH"]}:#{ENV["TRAVIS_DEPLOY_TARGET_BRANCH"]}`
puts "DONE, have a great day!"
ENV["TRAVIS_DEPLOY_PUSHED"] = "true"
