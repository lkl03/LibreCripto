/** @type {import('next').NextConfig} */
const nextConfig = {
  reactStrictMode: true,
  swcMinify: true,
}
const withVideos = require('next-videos')

module.exports = withVideos()
