module.exports = function(env) {
  if (env === undefined) {
    env = "dev"
  }
  return require(`./webpack/${env}.js`)
}
