<?php

/**
 * Represents 'something to be done'.
 *
 * Can be throught of as a zero-argument function with potentially
 * important side-effects and maybe a useful return value.
 * It's analogous to an IO monad in Haskell.
 *
 * This sort of thing is useful when you want to reason about an
 * action without necessarily doing it exactly once or right now,
 * or maybe without indicating implementation.
 *
 * Example use cases:
 * - Indicate a query to be run by a database driver to be chosen later
 * - Indicate an action that a user is trying to take before it's been
 *   proven that it's allowed or otherwise valid
 * - Represent a program instance to be run after arguments have
 *   been parsed
 * 
 * On the other hand, some actions might be as simple as implementing __invoke.
 * (Even though I said 'zero-argument', you may want to pass some sort of 'context'
 * to your action on which it can do work and ask about the environment).
 *
 * There are often several ways to model an action, the best of which
 * isn't always obvious and may be different depending on the
 * application.  But I should try to give some guidance for cases I know about.
 *
 *                               ~ ~ ~
 * 
 * Q: Should the ID of the user requesting an action be part of the action, or the context?
 * 
 * A: It's nice to think of actions as being independent of the user doing them.
 *    You may have functions like isUserAllowedToInvoke($user, $action) and
 *    invoke($action), but in some cases (e.g. when you want to do some logging),
 *    it's useful to know what user is doing the action during invoke(...).
 *    Two approaches are readily apparent:
 *    
 *    - Pass user ID separately, in a $context variable (so invoke($action, $context))
 *    - Include the invoking user ID as part of the action
 *    
 *    I lean towards the former approach, as otherwise all actions may end
 *    up being polluted with the sort of metadata that feels more natural
 *    as part of the context.  You can always have another action class like
 *    DoOnBehalfOf( $user, $action ) which, when invoked, runs the referenced
 *    action in an updated context.
 * 
 *                               ~ ~ ~
 * 
 * This base interface does not give any indication of what action is
 * to be done, how it is to be implemented, what context it runs in,
 * or what it returns.  It might represent a computation that can't be done.
 * You might choose to not even implement this interface since, after
 * all, it doesn't /do/ anything.
 *
 * But maybe you do just to indicate that an Action's what it is,
 * since that might not be obvious otherwise.
 */
interface TOGoS_Action { }
