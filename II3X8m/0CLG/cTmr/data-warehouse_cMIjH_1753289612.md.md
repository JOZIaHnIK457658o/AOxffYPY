# Contributing to dlt

Thank you for considering contributing to **dlt**! We appreciate your help in making dlt better. This document will guide you through the process of contributing to the project.

## Table of Contents

1. [Getting Started](#intro)
2. [Submitting Changes](#submitting-changes)
3. [Adding or updating core dependencies](#adding-or-updating-core-dependencies)
4. [Linting](#linting)
5. [Testing](#testing)
6. [Local Development](#local-development)
7. [Publishing (Maintainers Only)](#publishing-maintainers-only)
8. [Resources](#resources)

## Before You Begin

- **Proposing significant changes or enhancements**: If you're thinking about making significant changes, make sure to [submit an issue](https://github.com/dlt-hub/dlt/issues/new/choose) first. This ensures your efforts align with the project's direction and that you don't invest time on a feature that may not be merged. Please note:
   - 📣 **New destinations are unlikely to be merged** due to high maintenance cost (but we are happy to improve SQLAlchemy destination to handle more dialects)
   - Significant changes require tests and docs and in many cases writing tests will be more laborious than writing code
   - There's probably an [issue](https://github.com/dlt-hub/dlt/issues) for it—if so feel free to implement it

- **Small improvements**: We are super happy to get improvements if they are tested and documented.
   - more auth methods for destinations, optimization, additional options
   - quality of life—better log messages, improved exceptions, fixing inconsistent behaviors
  

- **Fixing bugs**:
  - Check existing issues: search [open issues](https://github.com/dlt-hub/dlt/issues) to see if the bug you've found is already reported.
    - If not reported, [create a new issue](https://github.com/dlt-hub/dlt/issues/new/choose). You're more than welcome to fix it and submit a pull request with your solution. Thank you!
    - If the bug is already reported, please leave a comment on that issue stating you're working on fixing it. This helps keep everyone updated and avoids duplicate efforts.


## Getting Started

To get started, follow these steps:

1. Fork the `dlt` repository and clone it to your local machine.
2. Install `uv` with `make install-uv` (or follow the [official instructions](https://docs.astral.sh/uv/getting-started/installation/).
3. Run `make dev` to install all dependencies including dev ones.
4. Activate your venv with `make shell` and starting working, or prepend all commands with `uv run` to run within the uv environment. `uv run` is encouraged as it will automatically keep you project dependencies up to date.

## Submitting Changes

When you're ready to contribute, follow these steps:

1. Create an issue describing the feature, bug fix, or improvement you'd like to make.
2. Create a new branch in your forked repository for your changes.
3. Write your code and tests.
4. Lint your code by running `make lint` and test common modules with `make test-common`.
5. If you're working on destination code, contact us to get access to test destinations.
6. Create a pull request targeting the **devel** branch of the main repository.

**Note:** for some special cases, you'd need to contact us to create a branch in this repository (not fork). See below.

### Active branches

We use **devel** (which is our default Github branch) to prepare a next release of `dlt`. We accept all regular contributions there (including most of the bugfixes).

We use **master** branch for hot fixes (including documentation) that needs to be released out of the normal schedule.

On the release day, **devel** branch is merged into **master**. All releases of `dlt` happen only from the **master**.

### Branch naming rules

We want to make sure that our git history explains in a human readable way what has been changed with which Branch or PR. To this end, we are using the following branch naming pattern (all lowercase and dashes, no underscores):

```sh
{category}/{ticket-id}-description-of-the-branch
# example:
feat/4922-add-avro-support
```

#### Branch categories

* **feat** - a new feature that is being implemented (ticket required)
* **fix** - a change that fixes a bug (ticket required)
* **exp** - an experiment where we are testing a new  idea or want to demonstrate something to the team, might turn into a `feat` later (ticket encouraged)
* **test** - anything related to the tests (ticket encouraged)
* **docs** - a change to our docs (ticket optional)
* **keep** - branches we want to keep an revisit later (ticket encouraged)

#### Ticket Numbers

We encourage you to attach your branches to a ticket, if none exists, create one and explain what you are doing. For `feat` and `fix` branches, tickets are mandatory, for `exp` and `test` branches encouraged and for `docs` branches optional.

### Submitting a hotfix
We'll fix critical bugs and release `dlt` out of the schedule. Follow the regular procedure, but make your PR against **master** branch. Please ping us on Slack if you do it.

### Submitting Changes Requiring Full CI Credentials.
We enable our CI to run tests for contributions from forks. By default only tests that do not require credentials are run. Full CI tests may be enabled with labels:
- `ci from fork` will enable access to CI credentials in PRs from fork and run associated tests
- `ci full` will run all tests. By default only essential destination tests are run.

Labels are assigned by the core team. If you need CI credentials for local tests you can contact us on Slack.


## Deprecation guidelines
We introduce breaking changes in major versions. In the meantime we maintain backward compatibility and deprecate behaviors and features. Example:
`complex` type got renamed to `json` in a minor version so backward compat was provided:
- we keep `complex` data type in schema definition
- `migrate_complex_types` is used to migrate schemas and at run time ie to handle `columns` hints
- `warning` Python module and `Dlt100DeprecationWarning` category is used to generate warning with full deprecation info

What is breaking change:
- A change in a well documented and common behavior that will break user's code.
- A change as above in undefined or undocumented behavior that we know is being used
- We do not consider changes that define behaviors or edge cases that were not documented and are not often used. Most of our QoL tickets are like that. Still, if possible,
backward compat should be provided.

Mechanisms to maintain backward compat:
- all schemas/state files have built-in migration methods (`engine_version`).
- storages (ie. extract/normalize/load) have versioned layout and may be upgraded or wiped out if version changes
- `DltDeprecationWarning` and variants with various version ranges. It automatically shows deprecation information and when deprecation will be removed from the code base
- `deprecated` decorator that can be applied to classes, functions and overloads which will generate warnings at runtime and when type checking (PEP702)
- backward compatibility must be tested. there are many such tests in our code base.
- we have end-to-end tests in `tests_dlt_versions.py`: pipelines are created with `venv` and old `dlt` (starting with `0.3.x`) and then upgraded and tested.

Please review `warnings.py` module and how deprecation warnings and decorators are used.

## Adding or updating core dependencies

Our objective is to maintain stability and compatibility of dlt across all environments.
By following these guidelines, we can make sure that dlt stays secure, reliable and compatible.
Please consider the following points carefully when proposing updates to dependencies.

### Updating guidelines

1. **Critical security or system integrity updates only:**
   Major or minor version updates to dependencies should only be considered if there are critical security vulnerabilities or issues that impact the system's integrity. In such cases, updating is necessary to protect the system and the data it processes.

2. **Using the '>=' operator:**
   When specifying dependencies, please make sure to use the `>=` operator while also maintaining version minima. This approach ensures our project remains compatible with older systems and setups, mitigating potential unsolvable dependency conflicts.

For example, if our project currently uses a package `example-package==1.2.3`, and a security update is
released as `1.2.4`, instead of updating to `example-package==1.2.4`, we can set it to `example-package>=1.2.3,<2.0.0`. This permits the necessary security update and at the same time
prevents the automatic jump to a potentially incompatible major version update in the future.
The other important note on using possible version minimas is to prevent potential cases where package
versions will not be resolvable.

## Linting

`dlt` uses `mypy` and `flake8` with several plugins for linting.

## Testing

dlt uses `pytest` for testing.

### Common Components

To test common components (which don't require external resources), run `make test-common`.

### Local Destinations

To test local destinations (`duckdb` and `postgres`), run `make test-load-local`.

### External Destinations

To test external destinations use `make test`. You will need the following external resources

1. `BigQuery` project
2. `Redshift` cluster
3. `Postgres` instance. You can find a docker compose for postgres instance [here](tests/load/postgres/docker-compose.yml). When run the instance is configured to work with the tests.

```shell
cd tests/load/postgres/
docker-compose up --build -d
```

See `tests/.example.env` for the expected environment variables and command line example to run the tests. Then create `tests/.env` from it. You configure the tests as you would configure the dlt pipeline.
We'll provide you with access to the resources above if you wish to test locally.

## Local Development

Use Python 3.9 for development, as it's the lowest supported version for `dlt`. You can select (and if needed download) the python version you need with `uv venv --python 3.11.6`, [uv python version docs](https://docs.astral.sh/uv/concepts/python-versions/#managed-and-system-python-installations).

## Publishing (Maintainers Only)

This section is intended for project maintainers who have the necessary permissions to manage the project's versioning and publish new releases. If you're a contributor, you can skip this section.

Please read how we [version the library](README.md#adding-as-dependency) first.

The source of truth for the current version is `pyproject.toml`, and we use `uv` to manage it.

### Regular release

Before publishing a new release, make sure to bump the project's version accordingly:

1. Check out the **devel** branch.
2. Use `uv version --bump patch` to increase the **patch** version. You can also bump to `minor` or `major`.
3. Run `make build-library` to apply the changes to the project.
4. Create a new branch, and submit the PR to **devel**. Go through the standard process to merge it.

Once the version has been bumped, follow these steps to publish the new release to PyPI:

1. Create a merge PR from `devel` to `master` and merge it with a ❗ **merge commit** (not squash) so `master` always mirrors `devel`
2. Ensure that you are on the **master** branch and have the latest code that has passed all tests on CI.
3. Verify the current version with `uv version`.
4. Obtain a PyPI access token
5. Build and publish the library with `make publish-library`, you will be asked to input the PyPI token.
6. Create a release on GitHub, using the version and git tag as the release name.

### Hotfix release
1. Check out the **master** branch
2. Use `uv version --bump patch` to increase the **patch** version
3. Run `make build-library` to apply the changes to the project.
4. Create a new branch, submit the PR to **master** and merge it.
5. Re-submit the same fix to the `devel` branch.

### Pre-release
Occasionally we may release an alpha version directly from the **branch**.
1. Check out the **devel** branch
2. You need to manually update the alpha version in the `pyproject.toml` file and run `uv sync` to update the uv lockfile.
3. Run `make build-library` to apply the changes to the project.
4. Create a new branch, and submit the PR to **devel** and merge it.

## Resources

- [dlt Docs](https://dlthub.com/docs)
- [uv Documentation](https://docs.astral.sh/uv/)

If you have any questions or need help, don't hesitate to reach out to us. We're here to help you succeed in contributing to `dlt`. Happy coding!
****