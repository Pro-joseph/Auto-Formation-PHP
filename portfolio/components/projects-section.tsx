"use client"

import { useRef, useEffect, useState } from "react"
import ProjectCard from "./project-card"

const projects = [
  {
    title: "E-Commerce Platform",
    description:
      "A modern e-commerce experience built with Next.js and a headless CMS. Features real-time inventory, seamless checkout, and beautiful product showcases with 3D product views.",
    tags: ["Next.js", "TypeScript", "Stripe", "Sanity"],
    color: "#4ecdc4",
    geometry: "box" as const,
  },
  {
    title: "Creative Agency Site",
    description:
      "An immersive website for a creative agency featuring scroll-driven animations, interactive case studies, and a dynamic portfolio that responds to user interaction.",
    tags: ["React", "Three.js", "GSAP", "Framer Motion"],
    color: "#45b7d1",
    geometry: "sphere" as const,
  },
  {
    title: "Dashboard Analytics",
    description:
      "A comprehensive analytics dashboard with real-time data visualization, custom charts, and intuitive filtering. Built for performance with virtualized lists and optimistic updates.",
    tags: ["React", "D3.js", "WebSocket", "PostgreSQL"],
    color: "#96ceb4",
    geometry: "torus" as const,
  },
  {
    title: "AI Content Studio",
    description:
      "An AI-powered content creation platform that helps creators generate, edit, and optimize their content. Features smart suggestions and seamless workflow integration.",
    tags: ["Next.js", "OpenAI", "Vercel AI SDK", "Tailwind"],
    color: "#88d8b0",
    geometry: "octahedron" as const,
  },
]

export default function ProjectsSection() {
  const sectionRef = useRef<HTMLElement>(null)
  const [visibleProjects, setVisibleProjects] = useState<boolean[]>(new Array(projects.length).fill(false))

  useEffect(() => {
    const observer = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          const index = Number(entry.target.getAttribute("data-index"))
          if (!isNaN(index)) {
            setVisibleProjects((prev) => {
              const newState = [...prev]
              newState[index] = entry.isIntersecting
              return newState
            })
          }
        })
      },
      {
        threshold: 0.3,
        rootMargin: "-10% 0px",
      }
    )

    const cards = sectionRef.current?.querySelectorAll("[data-index]")
    cards?.forEach((card) => observer.observe(card))

    return () => observer.disconnect()
  }, [])

  return (
    <section id="projects" ref={sectionRef} className="relative">
      <div className="sticky top-0 z-10 bg-background/80 px-6 py-6 backdrop-blur-sm md:px-12">
        <h2 className="text-sm font-medium uppercase tracking-widest text-muted-foreground">
          Selected Work
        </h2>
      </div>

      {projects.map((project, index) => (
        <div key={project.title} data-index={index}>
          <ProjectCard {...project} index={index} isVisible={visibleProjects[index]} />
        </div>
      ))}
    </section>
  )
}
