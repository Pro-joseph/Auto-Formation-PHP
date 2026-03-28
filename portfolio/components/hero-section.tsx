"use client"

import { ArrowDown } from "lucide-react"

export default function HeroSection() {
  return (
    <section id="home" className="relative flex min-h-screen flex-col items-center justify-center px-6">
      <div className="text-center">
        <p className="mb-4 text-sm uppercase tracking-widest text-muted-foreground">
          Creative Developer
        </p>
        <h1 className="mb-6 text-balance text-5xl font-bold tracking-tight text-foreground md:text-7xl lg:text-8xl">
          Building Digital
          <br />
          <span className="text-primary">Experiences</span>
        </h1>
        <p className="mx-auto max-w-md text-pretty text-base text-muted-foreground md:text-lg">
          I craft minimal, immersive web experiences with modern technologies and creative code.
        </p>
      </div>

      <a
        href="#projects"
        className="absolute bottom-12 flex flex-col items-center gap-2 text-sm text-muted-foreground transition-colors hover:text-foreground"
      >
        <span className="text-xs uppercase tracking-widest">Scroll to explore</span>
        <ArrowDown className="h-4 w-4 animate-bounce" />
      </a>
    </section>
  )
}
