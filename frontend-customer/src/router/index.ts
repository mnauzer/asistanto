import { createRouter, createWebHistory } from "vue-router"
import { useAuthStore } from "@/stores/auth"
import { ref } from "vue"
import type { RouteLocationNormalized, NavigationGuardNext } from "vue-router"
import NProgress from "nprogress"
import "nprogress/nprogress.css"

// Konfigurácia NProgress
NProgress.configure({ showSpinner: false })

const router = createRouter({
  history: createWebHistory(),
  routes: [
    {
      path: "/",
      component: () => import(/* webpackChunkName: "default-layout" */ "@/layouts/DefaultLayout.vue"),
      meta: { requiresAuth: true },
      children: [
        {
          path: "",
          name: "home",
          component: () => import(/* webpackChunkName: "home" */ "@/pages/HomePage.vue"),
          meta: {
            title: "Domov"
          }
        },
        {
          path: "dochadzka",
          name: "attendance",
          component: () => import(/* webpackChunkName: "attendance" */ "@/pages/AttendancePage.vue"),
          meta: {
            title: "Dochádzka"
          }
        }
      ]
    },
    {
      path: "/auth",
      component: () => import(/* webpackChunkName: "auth-layout" */ "@/layouts/AuthLayout.vue"),
      children: [
        {
          path: "login",
          name: "login",
          component: () => import(/* webpackChunkName: "login" */ "@/pages/LoginPage.vue"),
          meta: {
            title: "Prihlásenie"
          }
        }
      ]
    },
    {
      path: "/error",
      component: () => import(/* webpackChunkName: "error-layout" */ "@/layouts/ErrorLayout.vue"),
      children: [
        {
          path: "404",
          name: "not-found",
          component: () => import(/* webpackChunkName: "not-found" */ "@/pages/NotFoundPage.vue"),
          meta: {
            title: "Stránka nenájdená"
          }
        }
      ]
    },
    {
      path: "/error",
      component: () => import(/* webpackChunkName: "error-layout" */ "@/layouts/ErrorLayout.vue"),
      children: [
        {
          path: "403",
          name: "forbidden",
          component: () => import(/* webpackChunkName: "forbidden" */ "@/pages/ForbiddenPage.vue"),
          meta: {
            title: "Prístup zamietnutý"
          }
        },
        {
          path: "500",
          name: "server-error",
          component: () => import(/* webpackChunkName: "server-error" */ "@/pages/ServerErrorPage.vue"),
          meta: {
            title: "Chyba servera"
          }
        }
      ]
    },
    // Catch all route - presmeruje na 404
    {
      path: "/:pathMatch(.*)*",
      redirect: { name: "not-found" }
    }
  ]
})

// Global loading state
const globalLoading = ref(false)
export const useLoading = () => globalLoading

// Navigation guards
router.beforeEach(async (to, from, next) => {
  globalLoading.value = true
  // Start progress bar
  NProgress.start()

  // Update page title
  document.title = `${to.meta.title} | Asistanto` || "Asistanto"

  const authStore = useAuthStore()

  // Handle auth protected routes
  if (to.matched.some(record => record.meta.requiresAuth) && !authStore.token) {
    next({
      name: "login",
      query: { redirect: to.fullPath }
    })
    return
  }

  // Prevent authenticated users from accessing login page
  if (to.name === "login" && authStore.token) {
    next({ name: "home" })
    return
  }

  next()
})

router.afterEach(() => {
  // Complete progress bar
  NProgress.done()
  globalLoading.value = false
})

// Handle route-level transitions
router.beforeResolve(async (to: RouteLocationNormalized, from: RouteLocationNormalized, next: NavigationGuardNext) => {
  try {
    // Get all components for the target route
    const components = to.matched
      .map(record => Object.values(record.components || {}))
      .flat()

    // Wait for all async components to load
    await Promise.all(
      components.map(async (component: any) => {
        if (component?.asyncData) {
          await component.asyncData({
            route: to,
            store: useAuthStore()
          })
        }
      })
    )
    next()
  } catch (error) {
    if (error instanceof Error) {
      next({ name: 'server-error' })
    } else {
      next({ name: 'not-found' })
    }
  }
})

// Error handling
router.onError((error: unknown) => {
  console.error("Router error:", error)
  NProgress.done()

  if (error instanceof Error && error.message.includes('Failed to fetch dynamically imported module')) {
    window.location.reload()
  }
})

export default router
