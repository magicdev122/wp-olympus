# Define capistrano common vars
set :stage_config_path, "app/deploy/stages/"
set :deploy_config_path, "app/deploy/config.rb"

# Load DSL and set up stages
require "capistrano/setup"

# Include default deployment tasks
require "capistrano/deploy"

# Include olympus-hestia tool
require "capistrano/olympus-hestia"
