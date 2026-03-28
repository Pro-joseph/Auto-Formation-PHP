"use client"

import { useRef } from "react"
import { Canvas, useFrame } from "@react-three/fiber"
import { Float, MeshDistortMaterial, Environment } from "@react-three/drei"
import { ExternalLink } from "lucide-react"
import type { Mesh } from "three"

function ProjectMesh({ color, geometry }: { color: string; geometry: "box" | "sphere" | "torus" | "octahedron" }) {
  const meshRef = useRef<Mesh>(null)

  useFrame((state) => {
    if (meshRef.current) {
      meshRef.current.rotation.x = state.clock.elapsedTime * 0.3
      meshRef.current.rotation.y = state.clock.elapsedTime * 0.4
    }
  })

  const renderGeometry = () => {
    switch (geometry) {
      case "box":
        return <boxGeometry args={[1.5, 1.5, 1.5]} />
      case "sphere":
        return <sphereGeometry args={[1, 32, 32]} />
      case "torus":
        return <torusGeometry args={[1, 0.4, 16, 32]} />
      case "octahedron":
        return <octahedronGeometry args={[1.2]} />
      default:
        return <boxGeometry args={[1.5, 1.5, 1.5]} />
    }
  }

  return (
    <Float speed={2} rotationIntensity={0.5} floatIntensity={0.8}>
      <mesh ref={meshRef}>
        {renderGeometry()}
        <MeshDistortMaterial
          color={color}
          distort={0.3}
          speed={2}
          roughness={0.2}
          metalness={0.8}
        />
      </mesh>
    </Float>
  )
}

interface ProjectCardProps {
  title: string
  description: string
  tags: string[]
  color: string
  geometry: "box" | "sphere" | "torus" | "octahedron"
  index: number
  isVisible: boolean
}

export default function ProjectCard({
  title,
  description,
  tags,
  color,
  geometry,
  index,
  isVisible,
}: ProjectCardProps) {
  const isEven = index % 2 === 0

  return (
    <div
      className={`flex min-h-screen items-center px-6 py-24 transition-all duration-700 md:px-12 lg:px-24 ${
        isVisible ? "opacity-100 translate-y-0" : "opacity-0 translate-y-12"
      }`}
    >
      <div
        className={`mx-auto grid w-full max-w-6xl gap-12 lg:grid-cols-2 lg:gap-24 ${
          isEven ? "" : "lg:[direction:rtl]"
        }`}
      >
        {/* Text Content */}
        <div className={`flex flex-col justify-center ${isEven ? "" : "lg:[direction:ltr]"}`}>
          <span className="mb-4 text-xs font-medium uppercase tracking-widest text-primary">
            Project {String(index + 1).padStart(2, "0")}
          </span>
          <h2 className="mb-4 text-balance text-3xl font-bold tracking-tight text-foreground md:text-4xl lg:text-5xl">
            {title}
          </h2>
          <p className="mb-6 text-pretty text-base leading-relaxed text-muted-foreground md:text-lg">
            {description}
          </p>
          <div className="mb-8 flex flex-wrap gap-2">
            {tags.map((tag) => (
              <span
                key={tag}
                className="rounded-full bg-secondary px-3 py-1 text-xs font-medium text-secondary-foreground"
              >
                {tag}
              </span>
            ))}
          </div>
          <a
            href="#"
            className="group inline-flex w-fit items-center gap-2 text-sm font-medium text-foreground transition-colors hover:text-primary"
          >
            View Project
            <ExternalLink className="h-4 w-4 transition-transform group-hover:translate-x-1" />
          </a>
        </div>

        {/* 3D Preview */}
        <div className={`relative aspect-square lg:aspect-auto ${isEven ? "" : "lg:[direction:ltr]"}`}>
          <div className="absolute inset-0 rounded-2xl bg-card/50 backdrop-blur-sm" />
          <Canvas camera={{ position: [0, 0, 5], fov: 45 }}>
            <Environment preset="city" />
            <ambientLight intensity={0.5} />
            <pointLight position={[5, 5, 5]} intensity={1} />
            <ProjectMesh color={color} geometry={geometry} />
          </Canvas>
        </div>
      </div>
    </div>
  )
}
