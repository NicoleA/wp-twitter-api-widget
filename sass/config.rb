# http_path is dynamically constructed here so that this folder can be
# moved from theme to theme as needed.
tld = '/wp-content/'
dirs = File.expand_path(File.dirname(__FILE__)).split(tld)
http_path = tld + dirs[1] + '/'

css_dir = "../css"
sass_dir = "./"
images_dir = "sprite-src"
generated_images_dir = "../images/sprites"
http_generated_images_dir = "../images/sprites"
javascripts_dir = "../js"
environment = :development
relative_assets = true

# 3. You can select your preferred output style here (can be overridden via the command line):
output_style = :expanded

# 4. When you are ready to launch your WP theme comment out (3) and uncomment the line below
# output_style = :compressed

# To disable debugging comments that display the original location of your selectors. Uncomment:
# line_comments = false

# don't touch this
preferred_syntax = :scss