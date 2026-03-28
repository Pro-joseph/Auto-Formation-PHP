"use client"

import { useState, useEffect } from "react"
import dynamic from "next/dynamic"
import Navigation from "@/components/navigation"
import HeroSection from "@/components/hero-section"
import ProjectsSection from "@/components/projects-section"
import ContactSection from "@/components/contact-section"

const Scene3D = dynamic(() => import("@/components/scene-3d"), {
  ssr: false,
  loading: () => <div className="fixed inset-0 -z-10 bg-background" />,
})

export default function Home() {
  const [scrollProgress, setScrollProgress] = useState(0)

  useEffect(() => {
    const handleScroll = () => {
      const scrollY = window.scrollY
      const docHeight = document.documentElement.scrollHeight - window.innerHeight
      const progress = docHeight > 0 ? scrollY / docHeight : 0
      setScrollProgress(progress)
    }

    window.addEventListener("scroll", handleScroll, { passive: true })
    return () => window.removeEventListener("scroll", handleScroll)
  }, [])

  return (
    <main className="relative">
      <Scene3D scrollProgress={scrollProgress} />
      <Navigation />
      <HeroSection />
      <ProjectsSection />
      <ContactSection />
    </main>
  )
}
